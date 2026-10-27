import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { FaCar, FaGift, FaInfoCircle, FaEnvelope, FaFacebook, FaInstagram, FaTwitter, FaWhatsapp } from 'react-icons/fa';
import axios from 'axios';
import './Accueil.css';

function Accueil() {
  const [services, setServices] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    axios.get('http://localhost:8000/api/services')
      .then(response => {
        setServices(response.data.slice(0, 3));
        setLoading(false);
      })
      .catch(error => {
        console.error('Erreur en récupérant les services:', error);
        setLoading(false);
      });
  }, []);

  return (
    <div className="accueil-container">
      {/* Bannière Hero */}
      <section className="hero-banner">
        <div className="hero-content">
          <h1>🌿 Green Car Wash 🌿</h1>
          <p>Propreté, qualité et service premium pour votre véhicule</p>
          <Link to="/reservation" className="cta-button">Réserver maintenant</Link>
        </div>
      </section>

      {/* Section Services */}
      <section className="services-section">
        <div className="section-header">
          <h2>Nos Services Populaires</h2>
          <p>Découvrez nos services les plus demandés par nos clients fidèles</p>
        </div>
        {loading ? (
          <div className="loading-spinner">
            <div className="spinner"></div>
            <p>Chargement des services...</p>
          </div>
        ) : (
          <div className="services-grid">
            {services.map(service => (
              <div key={service.id} className="service-card">
                <div className="service-icon">
                  <FaCar />
                </div>
                <h3>{service.title}</h3>
                <p>{service.description}</p>
                <span className="service-price">{service.price}</span>
                <Link to="/reservation" className="service-button">Réserver</Link>
              </div>
            ))}
          </div>
        )}
        <Link to="/services" className="view-all-button">
          <span>Voir tous nos services</span>
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M8 0L6.59 1.41L12.17 7H0V9H12.17L6.59 14.59L8 16L16 8L8 0Z" fill="currentColor"/>
          </svg>
        </Link>
      </section>

      {/* Section Offres */}
      <section className="offers-section">
        <div className="section-header">
          <h2>Nos Offres Spéciales</h2>
          <p>Des forfaits adaptés à tous les besoins et budgets</p>
        </div>
        <div className="offers-grid">
          <div className="offer-card">
            <div className="offer-badge">Populaire</div>
            <h3>Forfait Basique</h3>
            <p>Lavage extérieur + aspiration</p>
            <span className="offer-price">70 MAD</span>
            <ul className="offer-features">
              <li>Lavage extérieur complet</li>
              <li>Aspiration intérieure</li>
              <li>Nettoyage des vitres</li>
            </ul>
            <Link to="/reservation" className="offer-button">Réserver</Link>
          </div>
          <div className="offer-card featured">
            <div className="offer-badge">Le plus choisi</div>
            <h3>Forfait Confort</h3>
            <p>Lavage complet intérieur et extérieur</p>
            <span className="offer-price">120 MAD</span>
            <ul className="offer-features">
              <li>Forfait Basique inclus</li>
              <li>Nettoyage des plastiques intérieurs</li>
              <li>Lustrage des surfaces</li>
              <li>Parfumage d'ambiance</li>
            </ul>
            <Link to="/reservation" className="offer-button">Réserver</Link>
          </div>
          <div className="offer-card">
            <div className="offer-badge">Premium</div>
            <h3>Forfait Premium</h3>
            <p>Lavage complet + traitement cire</p>
            <span className="offer-price">180 MAD</span>
            <ul className="offer-features">
              <li>Forfait Confort inclus</li>
              <li>Traitement cire protectrice</li>
              <li>Nettoyage des jantes</li>
              <li>Protection des pneus</li>
              <li>Service prioritaire</li>
            </ul>
            <Link to="/reservation" className="offer-button">Réserver</Link>
          </div>
        </div>
        <Link to="/offres" className="view-all-button">
          <span>Voir toutes nos offres</span>
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M8 0L6.59 1.41L12.17 7H0V9H12.17L6.59 14.59L8 16L16 8L8 0Z" fill="currentColor"/>
          </svg>
        </Link>
      </section>

      {/* Section À propos */}
      <section className="about-preview">
        <div className="about-content">
          <div className="about-text">
            <div className="section-header left-align">
              <h2>À propos de Green Car Wash</h2>
              <p>L'excellence du lavage automobile depuis plus de 10 ans</p>
            </div>
            <p>
              Avec plus de 10 ans d'expérience, Green Car Wash s'engage à offrir 
              un service de lavage automobile de qualité, rapide et respectueux 
              de l'environnement.
            </p>
            <p>
              Notre équipe de professionnels est dévouée à rendre votre véhicule 
              comme neuf, en utilisant des produits écologiques et des techniques 
              innovantes.
            </p>
            <Link to="/about" className="about-button">En savoir plus</Link>
          </div>
          <div className="about-image">
            <img src="https://images.pexels.com/photos/6872173/pexels-photo-6872173.jpeg" alt="Équipe Green Car Wash" />
          </div>
        </div>
      </section>

      {/* Section Contact */}
      <section className="contact-cta">
        <div className="cta-content">
          <h2>Prêt à donner un nouveau look à votre véhicule?</h2>
          <p>Contactez-nous dès aujourd'hui pour une estimation gratuite</p>
          <Link to="/contact" className="cta-button">Nous contacter</Link>
        </div>
      </section>

      {/* Footer */}
      <footer className="footer">
        <div className="footer-content">
          <div className="footer-section">
            <h3>Green Car Wash</h3>
            <p>Service de lavage automobile premium et écologique</p>
            <div className="footer-logo">🌿</div>
          </div>
          <div className="footer-section">
            <h4>Liens rapides</h4>
            <ul>
              <li><Link to="/">Accueil</Link></li>
              <li><Link to="/services">Services</Link></li>
              <li><Link to="/offres">Offres</Link></li>
              <li><Link to="/about">À propos</Link></li>
              <li><Link to="/contact">Contact</Link></li>
            </ul>
          </div>
          <div className="footer-section">
            <h4>Contactez-nous</h4>
            <div className="contact-info">
              <p><FaCar className="contact-icon" /> 123 Rue de Lavage, Rabat, Maroc</p>
              <p><FaEnvelope className="contact-icon" /> +212 6 12 34 56 78</p>
              <p><FaEnvelope className="contact-icon" /> contact@greencarwash.ma</p>
            </div>
          </div>
          <div className="footer-section">
            <h4>Suivez-nous</h4>
            <div className="social-icons">
              <a href="#"><FaFacebook /></a>
              <a href="#"><FaInstagram /></a>
              <a href="#"><FaTwitter /></a>
              <a href="#"><FaWhatsapp /></a>
            </div>
            {/* <div className="newsletter">
              <h5>Inscrivez-vous à notre newsletter</h5>
              <div className="newsletter-form">
                <input type="email" placeholder="Votre email" />
                <button>S'inscrire</button>
              </div>
            </div> */}
          </div>
        </div>
        <div className="footer-bottom">
          <p>&copy; 2024 Green Car Wash. Tous droits réservés.</p>
        </div>
      </footer>
    </div>
  );
}

export default Accueil;