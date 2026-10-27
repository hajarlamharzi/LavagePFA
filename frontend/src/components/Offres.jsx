import React from 'react';
import './Offres.css';

const offres = [
  {
    id: 1,
    name: 'Forfait Basique',
    includes: 'Lavage extérieur + aspiration',
    price: '70 MAD',
    features: [
      'Lavage extérieur complet',
      'Aspiration intérieure',
      'Nettoyage des vitres',
      'Durée: 30 minutes'
    ],
    popular: false,
    badge: 'Économique'
  },
  {
    id: 2,
    name: 'Forfait Confort',
    includes: 'Lavage complet intérieur et extérieur',
    price: '120 MAD',
    features: [
      'Forfait Basique inclus',
      'Nettoyage des plastiques intérieurs',
      'Lustrage des surfaces',
      'Parfumage d\'ambiance',
      'Durée: 1 heure'
    ],
    popular: true,
    badge: 'Le plus choisi'
  },
  {
    id: 3,
    name: 'Forfait Premium',
    includes: 'Lavage complet + traitement cire',
    price: '180 MAD',
    features: [
      'Forfait Confort inclus',
      'Traitement cire protectrice',
      'Nettoyage des jantes',
      'Protection des pneus',
      'Service prioritaire',
      'Durée: 1h30'
    ],
    popular: false,
    badge: 'Premium'
  },
];

function Offres() {
  return (
    <div className="offres-container">
      <div className="offres-header">
        <h2>Nos Offres & Tarifs</h2>
        <p>Des forfaits adaptés à tous les besoins et budgets</p>
      </div>

      <div className="offres-grid">
        {offres.map(offre => (
          <div 
            key={offre.id} 
            className={`offre-card ${offre.popular ? 'featured' : ''}`}
          >
            <div className="offre-badge">{offre.badge}</div>
            <h3>{offre.name}</h3>
            <p>{offre.includes}</p>
            <span className="offre-price">{offre.price}</span>
            
            <ul className="offre-features">
              {offre.features.map((feature, index) => (
                <li key={index}>{feature}</li>
              ))}
            </ul>
            
            <button className="offre-button">Réserver cette offre</button>
          </div>
        ))}
      </div>

      <div className="comparison-section">
        <h3>Tableau Comparatif</h3>
        <table className="comparison-table">
          <thead>
            <tr>
              <th>Services</th>
              <th>Basique</th>
              <th>Confort</th>
              <th>Premium</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Lavage extérieur</td>
              <td>✓</td>
              <td>✓</td>
              <td>✓</td>
            </tr>
            <tr>
              <td>Aspiration intérieure</td>
              <td>✓</td>
              <td>✓</td>
              <td>✓</td>
            </tr>
            <tr>
              <td>Nettoyage plastiques</td>
              <td>-</td>
              <td>✓</td>
              <td>✓</td>
            </tr>
            <tr>
              <td>Traitement cire</td>
              <td>-</td>
              <td>-</td>
              <td>✓</td>
            </tr>
            <tr>
              <td>Nettoyage jantes</td>
              <td>-</td>
              <td>-</td>
              <td>✓</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  );
}

export default Offres;