import React, { useState, useEffect } from 'react';
import { Link, useLocation } from 'react-router-dom';
import { FaHome, FaCar, FaGift, FaInfoCircle, FaEnvelope, FaUser, FaCalendarAlt, FaTimes, FaBars } from 'react-icons/fa';

function Navbar() {
  const [isScrolled, setIsScrolled] = useState(false);
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
  const location = useLocation();

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 10);
    };

    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  // Fermer le menu mobile quand la route change
  useEffect(() => {
    setIsMobileMenuOpen(false);
  }, [location]);

  return (
    <>
      <nav 
        className={`navbar ${isScrolled ? 'navbar-scrolled' : ''}`}
        style={{
          position: 'fixed',
          top: 0,
          left: 0,
          right: 0,
          zIndex: 1000,
          display: 'flex',
          justifyContent: 'space-between',
          alignItems: 'center',
          padding: '1rem 2rem',
          backgroundColor: isScrolled ? 'rgba(53, 56, 60, 0.95)' : '#35383cff',
          color: 'white',
          transition: 'all 0.3s ease',
          boxShadow: isScrolled ? '0 2px 10px rgba(0, 0, 0, 0.1)' : 'none'
        }}
      >
        {/* Logo à gauche */}
        <div style={{ fontWeight: 'bold', fontSize: '1.5rem', display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="28"
            height="28"
            fill="#28a745"
            viewBox="0 0 16 16"
          >
            <path
              fillRule="evenodd"
              d="M7.21.8C7.69.295 8 0 8 0q.164.544.371 1.038c.812 1.946 2.073 3.35 3.197 4.6C12.878 7.096 14 8.345 14 10a6 6 0 0 1-12 0C2 6.668 5.58 2.517 7.21.8m.413 1.021A31 31 0 0 0 5.794 3.99c-.726.95-1.436 2.008-1.96 3.07C3.304 8.133 3 9.138 3 10c0 0 2.5 1.5 5 .5s5-.5 5-.5c0-1.201-.796-2.157-2.181-3.7l-.03-.032C9.75 5.11 8.5 3.72 7.623 1.82z"
            />
            <path
              fillRule="evenodd"
              d="M4.553 7.776c.82-1.641 1.717-2.753 2.093-3.13l.708.708c-.29.29-1.128 1.311-1.907 2.87z"
            />
          </svg>

          <Link to="/" style={{ color: '#28a745', textDecoration: 'none' }}>
            Green Car Wash
          </Link>
        </div>

        {/* Liens navigation à droite (version desktop) */}
        <div className="desktop-nav" style={{ display: 'flex', gap: '1.5rem', alignItems: 'center' }}>
          <Link to="/" style={{ color: 'white', textDecoration: 'none', display: 'flex', alignItems: 'center', gap: '0.3rem' }}>
            <FaHome /> Accueil
          </Link>
          <Link to="/services" style={{ color: 'white', textDecoration: 'none', display: 'flex', alignItems: 'center', gap: '0.3rem' }}>
            <FaCar /> Services
          </Link>
          <Link to="/offres" style={{ color: 'white', textDecoration: 'none', display: 'flex', alignItems: 'center', gap: '0.3rem' }}>
            <FaGift /> Offres
          </Link>
          <Link to="/about" style={{ color: 'white', textDecoration: 'none', display: 'flex', alignItems: 'center', gap: '0.3rem' }}>
            <FaInfoCircle /> À propos
          </Link>
          <Link to="/contact" style={{ color: 'white', textDecoration: 'none', display: 'flex', alignItems: 'center', gap: '0.3rem' }}>
            <FaEnvelope /> Contact
          </Link>
          <Link to="/reservation" style={{ 
            backgroundColor: '#28a745', 
            color: 'white', 
            padding: '0.5rem 1rem', 
            borderRadius: '5px', 
            textDecoration: 'none',
            fontWeight: 'bold',
            display: 'flex',
            alignItems: 'center',
            gap: '0.3rem',
            transition: 'all 0.3s ease'
          }}>
            <FaCalendarAlt /> Réserver
          </Link>
        </div>

        {/* Bouton menu mobile */}
        <button 
          className="mobile-menu-btn"
          onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
          style={{
            display: 'none',
            background: 'none',
            border: 'none',
            color: 'white',
            fontSize: '1.5rem',
            cursor: 'pointer'
          }}
        >
          {isMobileMenuOpen ? <FaTimes /> : <FaBars />}
        </button>
      </nav>

      {/* Menu mobile */}
      <div 
        className={`mobile-nav ${isMobileMenuOpen ? 'mobile-nav-open' : ''}`}
        style={{
          position: 'fixed',
          top: '64px',
          left: 0,
          right: 0,
          backgroundColor: 'rgba(53, 56, 60, 0.98)',
          zIndex: 999,
          padding: '1rem',
          display: 'none',
          flexDirection: 'column',
          gap: '1rem',
          transform: 'translateY(-100%)',
          transition: 'transform 0.3s ease',
          boxShadow: '0 5px 15px rgba(0, 0, 0, 0.2)'
        }}
      >
        <Link to="/" style={{ color: 'white', textDecoration: 'none', display: 'flex', alignItems: 'center', gap: '0.5rem', padding: '0.5rem' }}>
          <FaHome /> Accueil
        </Link>
        <Link to="/services" style={{ color: 'white', textDecoration: 'none', display: 'flex', alignItems: 'center', gap: '0.5rem', padding: '0.5rem' }}>
          <FaCar /> Services
        </Link>
        <Link to="/offres" style={{ color: 'white', textDecoration: 'none', display: 'flex', alignItems: 'center', gap: '0.5rem', padding: '0.5rem' }}>
          <FaGift /> Offres
        </Link>
        <Link to="/about" style={{ color: 'white', textDecoration: 'none', display: 'flex', alignItems: 'center', gap: '0.5rem', padding: '0.5rem' }}>
          <FaInfoCircle /> À propos
        </Link>
        <Link to="/contact" style={{ color: 'white', textDecoration: 'none', display: 'flex', alignItems: 'center', gap: '0.5rem', padding: '0.5rem' }}>
          <FaEnvelope /> Contact
        </Link>
        <Link to="/reservation" style={{ 
          backgroundColor: '#28a745', 
          color: 'white', 
          padding: '0.7rem 1rem', 
          borderRadius: '5px', 
          textDecoration: 'none',
          fontWeight: 'bold',
          display: 'flex',
          alignItems: 'center',
          gap: '0.5rem',
          justifyContent: 'center',
          marginTop: '0.5rem'
        }}>
          <FaCalendarAlt /> Réserver
        </Link>
      </div>

      {/* Espace pour compenser la navbar fixe */}
      <div style={{ height: '76px' }}></div>

      <style>
        {`
          /* Styles pour le survol des liens */
          .desktop-nav a:hover, .mobile-nav a:hover {
            color: #28a745 !important;
            transform: translateY(-2px);
          }
          
          /* Styles responsives */
          @media (max-width: 900px) {
            .desktop-nav {
              display: none !important;
            }
            
            .mobile-menu-btn {
              display: block !important;
            }
            
            .mobile-nav {
              display: flex !important;
            }
            
            .mobile-nav-open {
              transform: translateY(0) !important;
            }
          }
          
          @media (min-width: 901px) {
            .mobile-nav {
              display: none !important;
            }
          }
        `}
      </style>
    </>
  );
}

export default Navbar;