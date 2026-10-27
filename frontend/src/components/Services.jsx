import React from 'react';
import { Link } from 'react-router-dom';
import { FaCar, FaHome, FaShieldAlt, FaStar } from 'react-icons/fa';
import './Services.css';

function Services() {
  const services = [
    {
      id: 1,
      title: 'Lavage extérieur',
      description: 'Nettoyage complet de la carrosserie pour une brillance optimale avec nos produits écologiques.',
      price: '50 MAD',
      icon: <FaCar />,
      features: ['Nettoyage haute pression', 'Shampoing écologique', 'Séchage à la microfibre', 'Brillance optimale']
    },
    {
      id: 2,
      title: 'Lavage intérieur',
      description: 'Aspiration et nettoyage en profondeur de l\'intérieur du véhicule avec des produits spécialisés.',
      price: '40 MAD',
      icon: <FaShieldAlt />,
      features: ['Aspiration complète', 'Nettoyage des sièges', 'Dépoussiérage tableau de bord', 'Désodorisation']
    },
    {
      id: 3,
      title: 'Lavage complet',
      description: 'Service premium combinant lavage intérieur et extérieur pour un résultat parfait.',
      price: '80 MAD',
      icon: <FaStar />,
      features: ['Lavage extérieur complet', 'Nettoyage intérieur approfondi', 'Nettoyage des vitres', 'Parfum d\'ambiance']
    },
    {
      id: 4,
      title: 'Lavage à domicile',
      description: 'Service de lavage complet directement chez vous, à votre convenance.',
      price: '100 MAD',
      icon: <FaHome />,
      features: ['Service mobile', 'Économie de temps', 'Produits écologiques', 'Satisfaction garantie']
    },
  ];

  return (
    <div className="services-container">
      <div className="services-header">
        <h1>Nos Services Premium</h1>
        <p>Découvrez notre gamme complète de services de lavage automobile écologique et professionnel</p>
      </div>

      <div className="services-grid">
        {services.map(service => (
          <div key={service.id} className="service-card">
            <div className="service-icon">
              {service.icon}
            </div>
            <h3>{service.title}</h3>
            <p>{service.description}</p>
            <span className="service-price">{service.price}</span>
            
            <ul className="service-features">
              {service.features.map((feature, index) => (
                <li key={index}>{feature}</li>
              ))}
            </ul>
            
            <Link to="/reservation" className="service-button">
              Réserver maintenant
            </Link>
          </div>
        ))}
      </div>

      <div className="services-cta">
        <h2>Prêt à redonner de l'éclat à votre véhicule ?</h2>
        <p>Réservez dès maintenant et bénéficiez de 10% de réduction sur votre premier lavage !</p>
        <Link to="/reservation" className="cta-button">
          Réserver une prestation
        </Link>
      </div>
    </div>
  );
}

export default Services;