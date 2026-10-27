// src/components/ServicesPreview.jsx
import React from 'react';
import { FaCar, FaSprayCan, FaHome } from 'react-icons/fa';

const services = [
  { icon: <FaCar />, title: 'Lavage extérieur', description: 'Nettoyage complet extérieur' },
  { icon: <FaSprayCan />, title: 'Lavage intérieur', description: 'Aspirateur, tapis, sièges' },
  { icon: <FaCar />, title: 'Lavage complet', description: 'Extérieur + Intérieur' },
  { icon: <FaHome />, title: 'Lavage à domicile', description: 'On vient jusqu’à chez vous' },
];

function ServicesPreview() {
  return (
    <div className="services-preview">
      <h2>Nos Services</h2>
      <div className="service-cards">
        {services.map((s, idx) => (
          <div className="card" key={idx}>
            <div className="icon">{s.icon}</div>
            <h3>{s.title}</h3>
            <p>{s.description}</p>
            <p className="price">Prix: 50 MAD</p>
          </div>
        ))}
      </div>
    </div>
  );
}

export default ServicesPreview;
