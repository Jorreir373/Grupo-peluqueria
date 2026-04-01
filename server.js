const express = require('express');
const nodemailer = require('nodemailer');
const cors = require('cors');

const app = express();
app.use(cors());
app.use(express.json()); // Para entender datos en formato JSON
app.use(express.urlencoded({ extended: true }));

// Configuración de Nodemailer (Acá ponés tus datos reales)
const transporter = nodemailer.createTransport({
    service: 'gmail',
    auth: {
        user: 'tomyferreyra13@gmail.com', // Tu Gmail
        pass: 'dzac jaqp ioss cfwi' // La clave de 16 letras que te da Google
    }
});

// Ruta que va a recibir la petición de tu página
app.post('/enviar-correo', (req, res) => {
    const { cliente, email, servicio, fecha, hora } = req.body;

    const mailOptions = {
        from: 'Peluquería Estilo Único <tu_correo@gmail.com>',
        to: email,
        subject: '¡Turno Confirmado! - Estilo Único ✂️',
        html: `
            <div style="font-family: Arial, sans-serif; padding: 20px; background-color: #f4f6f9; border-radius: 10px;">
                <h2 style="color: #4f46e5;">¡Hola ${cliente}! 👋</h2>
                <p>Tu turno ha sido confirmado exitosamente en <strong>Estilo Único</strong>.</p>
                <div style="background-color: white; padding: 15px; border-radius: 8px; margin: 20px 0;">
                    <p><strong>💈 Servicio:</strong> ${servicio}</p>
                    <p><strong>📅 Fecha:</strong> ${fecha}</p>
                    <p><strong>⏰ Hora:</strong> ${hora}</p>
                </div>
                <p>¡Te esperamos!</p>
            </div>
        `
    };

    transporter.sendMail(mailOptions, (error, info) => {
        if (error) {
            console.log("Error al enviar:", error);
            res.status(500).send('Error al enviar el correo');
        } else {
            console.log('Correo enviado: ' + info.response);
            res.status(200).send('Correo enviado con éxito');
        }
    });
});

const PORT = 3000;
app.listen(PORT, () => {
    console.log(`🚀 Servidor de correos corriendo en http://localhost:${PORT}`);
});