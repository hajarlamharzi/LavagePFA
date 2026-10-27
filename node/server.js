const express = require('express');
const { Client, LocalAuth } = require('whatsapp-web.js');
const qrcode = require('qrcode-terminal');

const app = express();
app.use(express.json());

const client = new Client({
    authStrategy: new LocalAuth()
});

client.on('qr', (qr) => {
    console.log('🔵 QR CODE à scanner dans WhatsApp Web :');
    qrcode.generate(qr, { small: true });
});

client.on('ready', () => {
    console.log('✅ WhatsApp Web est prêt pour envoyer les messages !');
});

client.initialize();

app.post('/send-message', async (req, res) => {
    let { phone, message } = req.body;

    if (!phone || !message) {
        return res.status(400).json({ error: 'Phone and message are required.' });
    }

    // Nettoyer le numéro
    phone = phone.replace(/\s+/g, '').replace(/[-()]/g, '');

    if (!phone.startsWith('+')) {
        return res.status(400).json({ error: 'Phone number must start with + and include country code.' });
    }

    try {
        // Vérifier si le numéro est sur WhatsApp
        const isRegistered = await client.isRegisteredUser(`${phone}@c.us`);
        if (!isRegistered) {
            console.log(`❌ Le numéro ${phone} n'est PAS inscrit sur WhatsApp`);
            return res.status(400).json({ error: `Le numéro ${phone} n'est pas inscrit sur WhatsApp.` });
        }

        // Envoyer le message
        await client.sendMessage(`${phone}@c.us`, message);
        console.log(`✅ Message WhatsApp envoyé à ${phone}`);
        res.json({ success: true, message: `Message envoyé à ${phone}` });
    } catch (err) {
        console.error('❌ Erreur envoi :', err);
        res.status(500).json({ error: 'Erreur lors de l\'envoi du message', details: err.message });
    }
});

app.listen(3000, () => {
    console.log('🟢 Serveur WhatsApp Web Express écoute sur http://localhost:3000');
});
