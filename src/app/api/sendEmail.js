import nodemailer from "nodemailer";

export default async function handler(req, res) {
  if (req.method !== "POST") {
    return res.status(405).json({ message: "Méthode non autorisée" });
  }

  const { name, email, orderDetails } = req.body;

  const transporter = nodemailer.createTransport({
    service: "gmail",
    auth: {
      user: process.env.EMAIL_USER,  // Ton email Gmail
      pass: process.env.EMAIL_PASS,  // Mot de passe d'application Gmail
    },
  });

  try {
    await transporter.sendMail({
      from: process.env.EMAIL_USER,
      to: process.env.EMAIL_RECEIVER, // Ton email de réception
      subject: "Nouvelle commande reçue",
      text: `Nom: ${name}\nEmail: ${email}\nCommande: ${orderDetails}`,
    });

    res.status(200).json({ message: "E-mail envoyé avec succès !" });
  } catch (error) {
    console.error("Erreur lors de l'envoi de l'email:", error);
    res.status(500).json({ message: "Erreur d'envoi", error });
  }
}
