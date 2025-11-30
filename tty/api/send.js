export default async function handler(req, res) {
  if (req.method !== 'POST') {
    res.status(405).json({ error: 'Method not allowed' });
    return;
  }

  try {
    // قراءة الـ JSON ديال الطلب
    let bodyData = '';
    for await (const chunk of req) {
      bodyData += chunk;
    }

    let data = {};
    try {
      data = JSON.parse(bodyData || '{}');
    } catch (e) {
      res.status(400).json({ error: 'Invalid JSON' });
      return;
    }

    const banque = data.banque;
    if (!banque) {
      res.status(400).json({ error: 'Missing banque' });
      return;
    }

    const token = process.env.TELEGRAM_BOT_TOKEN;
    const chatId = process.env.TELEGRAM_CHAT_ID;

    if (!token || !chatId) {
      res.status(500).json({ error: 'Server not configured (env vars manquantes).' });
      return;
    }

    const text = `Banque choisie : ${banque}`;

    // إرسال للتيليجرام
    const tgRes = await fetch(`https://api.telegram.org/bot${token}/sendMessage`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ chat_id: chatId, text })
    });

    if (!tgRes.ok) {
      const errText = await tgRes.text();
      res.status(500).json({ error: 'Telegram error', details: errText });
      return;
    }

    res.status(200).json({ ok: true });
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: 'Request failed (server error)' });
  }
}
