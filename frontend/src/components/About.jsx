import React, { useEffect, useRef, useState } from 'react';
import './About.css';

// Composant Counter pour l'animation des chiffres
const Counter = ({ from, to, duration, suffix = "" }) => {
  const [count, setCount] = useState(from);
  const [hasAnimated, setHasAnimated] = useState(false);
  const ref = useRef();

  useEffect(() => {
    const observer = new IntersectionObserver(
      ([entry]) => {
        if (entry.isIntersecting && !hasAnimated) {
          setHasAnimated(true);
          let startTime = null;
          
          const animate = (timestamp) => {
            if (!startTime) startTime = timestamp;
            const progress = Math.min((timestamp - startTime) / duration, 1);
            
            // Easing function pour un effet plus naturel
            const easeOutQuart = 1 - Math.pow(1 - progress, 4);
            const currentCount = Math.floor(from + easeOutQuart * (to - from));
            
            setCount(currentCount);
            
            if (progress < 1) {
              requestAnimationFrame(animate);
            }
          };
          
          requestAnimationFrame(animate);
        }
      },
      { threshold: 0.3 }
    );

    if (ref.current) {
      observer.observe(ref.current);
    }

    return () => observer.disconnect();
  }, [from, to, duration, hasAnimated]);

  return (
    <span ref={ref}>
      {count}{suffix}
    </span>
  );
};

function About() {
  const [statsVisible, setStatsVisible] = useState(false);
  const statsRef = useRef(null);

  useEffect(() => {
    // Ajouter une classe pour les animations après le chargement
    document.body.classList.add('about-loaded');

    // Observer pour la section des statistiques
    const observer = new IntersectionObserver(
      ([entry]) => {
        if (entry.isIntersecting) {
          setStatsVisible(true);
        }
      },
      { threshold: 0.3 }
    );

    if (statsRef.current) {
      observer.observe(statsRef.current);
    }

    return () => observer.disconnect();
  }, []);

  return (
    <div className="about-container">
      <div className="about-header">
        <h2>À propos de Green Car Wash</h2>
        <p>L'excellence du lavage automobile depuis plus de 10 ans</p>
      </div>

      <div className="about-content">
        <div className="about-text">
          <h3>Notre Histoire</h3>
          <p>
            Fondé en 2014, Green Car Wash est né de la passion pour l'automobile 
            et du respect de l'environnement. Nous avons révolutionné le secteur 
            du lavage automobile en proposant des solutions écologiques et efficaces.
          </p>
          <p>
            Notre engagement envers la qualité et le service client nous a permis 
            de devenir la référence en matière de lavage automobile premium au Maroc.
          </p>
        </div>
        
        <div className="about-text">
          <h3>Notre Mission</h3>
          <p>
            Offrir à chaque client une expérience de lavage exceptionnelle, 
            en utilisant des technologies de pointe et des produits respectueux 
            de l'environnement.
          </p>
          <p>
            Nous nous engageons à réduire notre impact écologique tout en 
            garantissant un résultat impeccable pour votre véhicule.
          </p>
        </div>
      </div>

      <div className="about-stats" ref={statsRef}>
        <div className="stat">
          <span className="stat-number">
            {statsVisible ? <Counter from={0} to={10} duration={2000} /> : "0"}+
          </span>
          <span className="stat-label">Ans d'expérience</span>
        </div>
        <div className="stat">
          <span className="stat-number">
            {statsVisible ? <Counter from={0} to={5000} duration={2500} /> : "0"}+
          </span>
          <span className="stat-label">Clients satisfaits</span>
        </div>
        <div className="stat">
          <span className="stat-number">
            {statsVisible ? <Counter from={0} to={100} duration={1500} suffix="%" /> : "0%"}
          </span>
          <span className="stat-label">Écologique</span>
        </div>
      </div>

      <div className="team-section">
        <h3>Notre Équipe d'Experts</h3>
        <div className="team-grid">
          <div className="team-member">
            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" alt="Directeur" />
            <h4>Ahmed El Amrani</h4>
            <p>Directeur & Fondateur</p>
          </div>
          <div className="team-member">
            <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" alt="Responsable qualité" />
            <h4>Fatima Zahra</h4>
            <p>Responsable Qualité</p>
          </div>
          <div className="team-member">
            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" alt="Expert lavage" />
            <h4>Karim Benjelloun</h4>
            <p>Expert Lavage Premium</p>
          </div>
        </div>
      </div>
    </div>
  );
}

export default About;