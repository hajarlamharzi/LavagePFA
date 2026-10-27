// src/components/Banner.jsx
import React from 'react';
import './Banner.css'; // tu peux le styler avec tailwind si tu veux

function Banner() {
  return (
    <div className="banner">
      <img
        src="https://images.unsplash.com/photo-1604147706288-f9d4d7c9f1f5"
        alt="Bannière lavage voiture"
        className="banner-img"
      />
      <div className="banner-content">
        <h1 className="slogan">Votre voiture mérite le meilleur soin 🚗✨</h1>
        <a href="/reserver">
          <button className="btn-reserver">Réserver maintenant</button>
        </a>
      </div>
    </div>
  );
}

export default Banner;
