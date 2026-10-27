import React, { useState, useEffect } from 'react';
import api, { getCsrfToken } from '../services/api';

function Contact() {
  const [formData, setFormData] = useState({ nom: '', email: '', message: '' });
  const [success, setSuccess] = useState(false);
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);
  const [appInitialized, setAppInitialized] = useState(false);
  const [initializing, setInitializing] = useState(true);
  const [debugInfo, setDebugInfo] = useState('');

  useEffect(() => {
    const init = async () => {
      try {
        console.log('Initialisation de la connexion au serveur...');
        await getCsrfToken();
        
        const hasXsrfToken = document.cookie.includes('XSRF-TOKEN');
        const hasLaravelSession = document.cookie.includes('laravel_session');
        
        setAppInitialized(hasXsrfToken);
        
        setDebugInfo(
          `Statut: ${hasXsrfToken ? 'Connecté' : 'Déconnecté'} | ` +
          `XSRF: ${hasXsrfToken ? '✓' : '✗'} | ` +
          `Session: ${hasLaravelSession ? '✓' : '✗'}`
        );
        
      } catch (err) {
        console.error('Erreur d\'initialisation:', err);
        setError(`Erreur de connexion: ${err.message}`);
        setDebugInfo(`Échec de la connexion: ${err.message}`);
      } finally {
        setInitializing(false);
      }
    };

    init();
  }, []);

  const handleChange = (e) => {
    setFormData(prev => ({ ...prev, [e.target.name]: e.target.value }));
  };

  const testConnection = async () => {
    try {
      setLoading(true);
      setError('');
      await getCsrfToken();
      
      const hasXsrfToken = document.cookie.includes('XSRF-TOKEN');
      setAppInitialized(hasXsrfToken);
      setDebugInfo('Connexion testée avec succès');
    } catch (err) {
      setDebugInfo('Erreur: ' + err.message);
    } finally {
      setLoading(false);
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    
    if (!appInitialized) {
      setError('Application non initialisée. Cliquez sur "Tester la connexion"');
      return;
    }

    setLoading(true);
    setError('');

    try {
      const response = await api.post('/api/contact', formData);
      setSuccess(true);
      setFormData({ nom: '', email: '', message: '' });
      setTimeout(() => setSuccess(false), 5000);
    } catch (err) {
      console.error('Erreur d\'envoi:', err);
      setError('Erreur lors de l\'envoi: ' + (err.response?.data?.message || err.message));
    } finally {
      setLoading(false);
    }
  };

  const getConnectionStatus = () => {
    if (initializing) return '🔄 Initialisation...';
    return appInitialized ? '✅ Connecté au serveur' : '❌ Hors ligne';
  };

  return (
    <div className="contact-page">
      <div className="contact-container">
        <div className="contact-content">
          <div className="contact-form-section">
            <div className="contact-header">
              <h1>Contactez-Nous</h1>
              <p>Nous sommes là pour répondre à toutes vos questions</p>
            </div>
            
            {/* Statut de connexion */}
            <div className={`connection-status ${appInitialized ? 'connected' : 'disconnected'}`}>
              <div className="status-indicator"></div>
              <span>{getConnectionStatus()}</span>
            </div>

            {/* Debug info */}
            <div className="debug-info">
              <span className="debug-icon">⚙️</span>
              {debugInfo}
            </div>

            {!appInitialized && !initializing && (
              <div className="connection-warning">
                <div className="warning-icon">⚠️</div>
                <p>La connexion au serveur a échoué</p>
                <button 
                  onClick={testConnection}
                  disabled={loading}
                  className="test-connection-btn"
                >
                  {loading ? '🔄 Test en cours...' : '🔄 Tester la connexion'}
                </button>
              </div>
            )}

            {success && (
              <div className="success-message">
                <span className="success-icon">✅</span>
                Message envoyé avec succès ! Nous vous répondrons rapidement.
              </div>
            )}
            
            {error && (
              <div className="error-message">
                <span className="error-icon">❌</span>
                {error}
              </div>
            )}

            <form onSubmit={handleSubmit} className="contact-form">
              <div className="form-group">
                <label htmlFor="nom">Nom complet</label>
                <input
                  type="text"
                  id="nom"
                  name="nom"
                  value={formData.nom}
                  onChange={handleChange}
                  required
                  disabled={loading}
                  placeholder="Votre nom complet"
                />
              </div>

              <div className="form-group">
                <label htmlFor="email">Adresse email</label>
                <input
                  type="email"
                  id="email"
                  name="email"
                  value={formData.email}
                  onChange={handleChange}
                  required
                  disabled={loading}
                  placeholder="votre@email.com"
                />
              </div>

              <div className="form-group">
                <label htmlFor="message">Votre message</label>
                <textarea
                  id="message"
                  name="message"
                  value={formData.message}
                  onChange={handleChange}
                  required
                  disabled={loading}
                  rows="6"
                  placeholder="Décrivez votre demande en détail..."
                />
              </div>

              <button 
                type="submit" 
                disabled={loading || !appInitialized}
                className="submit-btn"
              >
                {loading ? (
                  <>
                    <span className="spinner"></span>
                    Envoi en cours...
                  </>
                ) : !appInitialized ? (
                  '📡 Connexion requise'
                ) : (
                  <>
                    <span className="send-icon">✉️</span>
                    Envoyer le message
                  </>
                )}
              </button>
            </form>
          </div>

          <div className="contact-info-section">
            <div className="info-card">
              <div className="card-header">
                <h2>Informations de contact</h2>
                <div className="decoration-line"></div>
              </div>
              
              <div className="contact-details">
                <div className="contact-item">
                  <div className="icon-wrapper">
                    <span className="icon">🏢</span>
                  </div>
                  <div className="contact-text">
                    <h3>Notre adresse</h3>
                    <p>123 Rue de Lavage<br />Rabat, Maroc</p>
                  </div>
                </div>

                <div className="contact-item">
                  <div className="icon-wrapper">
                    <span className="icon">📞</span>
                  </div>
                  <div className="contact-text">
                    <h3>Téléphone</h3>
                    <p>+212 6 12 34 56 78</p>
                  </div>
                </div>

                <div className="contact-item">
                  <div className="icon-wrapper">
                    <span className="icon">✉️</span>
                  </div>
                  <div className="contact-text">
                    <h3>Email</h3>
                    <p>contact@lavageauto.ma</p>
                  </div>
                </div>

                <div className="contact-item">
                  <div className="icon-wrapper">
                    <span className="icon">🕒</span>
                  </div>
                  <div className="contact-text">
                    <h3>Horaires d'ouverture</h3>
                    <p>Lun - Sam: 8h00 - 20h00<br />Dimanche: 9h00 - 18h00</p>
                  </div>
                </div>
              </div>

              <div className="map-container">
                <iframe
                  title="google-map"
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3307.23812613238!2d-6.832396884785!3d34.02082692636085!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xda76b8f7f2a70a9%3A0x6f5b3a3a3a3a3a3a!2sRabat%2C%20Maroc!5e0!3m2!1sfr!2sma!4v1620000000000!5m2!1sfr!2sma"
                  width="100%"
                  height="200"
                  allowFullScreen=""
                  loading="lazy"
                />
              </div>
            </div>
          </div>
        </div>
      </div>

      <style jsx>{`
        .contact-page {
          min-height: 100vh;
          background: linear-gradient(135deg, #10b981 0%, #059669 100%);
          padding: 2rem;
          font-family: 'Inter', 'Segoe UI', sans-serif;
        }
        
        .contact-container {
          max-width: 1400px;
          margin: 0 auto;
          background: rgba(255, 255, 255, 0.95);
          backdrop-filter: blur(20px);
          border-radius: 24px;
          overflow: hidden;
          box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
        }
        
        .contact-content {
          display: grid;
          grid-template-columns: 1.2fr 0.8fr;
          min-height: 800px;
        }
        
        .contact-form-section {
          padding: 4rem;
          background: white;
        }
        
        .contact-info-section {
          background: linear-gradient(135deg, #10b981 0%, #059669 100%);
          padding: 3rem;
          display: flex;
          align-items: center;
          justify-content: center;
          position: relative;
          overflow: hidden;
        }
        
        .contact-info-section::before {
          content: '';
          position: absolute;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
        }
        
        .contact-header {
          text-align: center;
          margin-bottom: 3rem;
        }
        
        .contact-header h1 {
          font-size: 3rem;
          color: #2c3e50;
          margin-bottom: 1rem;
          font-weight: 700;
          background: linear-gradient(135deg, #10b981 0%, #059669 100%);
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
        }
        
        .contact-header p {
          color: #7f8c8d;
          font-size: 1.2rem;
          font-weight: 300;
        }
        
        .connection-status {
          display: flex;
          align-items: center;
          gap: 1rem;
          padding: 1.2rem;
          border-radius: 12px;
          margin-bottom: 1.5rem;
          font-weight: 600;
          font-size: 1.1rem;
          backdrop-filter: blur(10px);
        }
        
        .connection-status.connected {
          background: rgba(72, 187, 120, 0.1);
          color: #155724;
          border: 1px solid rgba(72, 187, 120, 0.3);
        }
        
        .connection-status.disconnected {
          background: rgba(245, 101, 101, 0.1);
          color: #721c24;
          border: 1px solid rgba(245, 101, 101, 0.3);
        }
        
        .status-indicator {
          width: 12px;
          height: 12px;
          border-radius: 50%;
          animation: pulse 2s infinite;
        }
        
        .connection-status.connected .status-indicator {
          background: #48bb78;
        }
        
        .connection-status.disconnected .status-indicator {
          background: #f56565;
        }
        
        .debug-info {
          background: rgba(16, 185, 129, 0.05);
          padding: 1rem;
          border-radius: 8px;
          font-size: 0.9rem;
          margin-bottom: 1.5rem;
          border-left: 4px solid #10b981;
          display: flex;
          align-items: center;
          gap: 0.5rem;
          color: #4b5563;
        }
        
        .debug-icon {
          font-size: 1.2rem;
        }
        
        .connection-warning {
          background: rgba(251, 191, 36, 0.1);
          border: 1px solid rgba(251, 191, 36, 0.3);
          padding: 1.5rem;
          border-radius: 12px;
          margin-bottom: 1.5rem;
          text-align: center;
        }
        
        .warning-icon {
          font-size: 2rem;
          margin-bottom: 0.5rem;
        }
        
        .test-connection-btn {
          background: linear-gradient(135deg, #10b981 0%, #059669 100%);
          color: white;
          border: none;
          padding: 1rem 2rem;
          border-radius: 8px;
          cursor: pointer;
          font-weight: 600;
          transition: all 0.3s ease;
          margin-top: 1rem;
          font-size: 1rem;
        }
        
        .test-connection-btn:hover:not(:disabled) {
          transform: translateY(-2px);
          box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        }
        
        .test-connection-btn:disabled {
          background: #9ca3af;
          cursor: not-allowed;
        }
        
        .success-message {
          background: rgba(72, 187, 120, 0.1);
          color: #155724;
          padding: 1.5rem;
          border-radius: 12px;
          margin-bottom: 1.5rem;
          border: 1px solid rgba(72, 187, 120, 0.3);
          display: flex;
          align-items: center;
          gap: 0.5rem;
          font-weight: 600;
        }
        
        .error-message {
          background: rgba(245, 101, 101, 0.1);
          color: #721c24;
          padding: 1.5rem;
          border-radius: 12px;
          margin-bottom: 1.5rem;
          border: 1px solid rgba(245, 101, 101, 0.3);
          display: flex;
          align-items: center;
          gap: 0.5rem;
          font-weight: 600;
        }
        
        .contact-form {
          display: flex;
          flex-direction: column;
          gap: 2rem;
        }
        
        .form-group {
          display: flex;
          flex-direction: column;
        }
        
        .form-group label {
          margin-bottom: 0.8rem;
          color: #374151;
          font-weight: 600;
          font-size: 1.1rem;
        }
        
        .form-group input,
        .form-group textarea {
          padding: 1.2rem;
          border: 2px solid #e5e7eb;
          border-radius: 12px;
          font-size: 1rem;
          transition: all 0.3s ease;
          background: #f9fafb;
          font-family: inherit;
        }
        
        .form-group input:focus,
        .form-group textarea:focus {
          outline: none;
          border-color: #10b981;
          background: white;
          box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
          transform: translateY(-2px);
        }
        
        .form-group input:disabled,
        .form-group textarea:disabled {
          background: #f3f4f6;
          cursor: not-allowed;
        }
        
        .submit-btn {
          background: linear-gradient(135deg, #10b981 0%, #059669 100%);
          color: white;
          border: none;
          padding: 1.4rem 2rem;
          border-radius: 12px;
          font-size: 1.2rem;
          font-weight: 600;
          cursor: pointer;
          transition: all 0.3s ease;
          display: flex;
          align-items: center;
          justify-content: center;
          gap: 0.8rem;
          margin-top: 1rem;
          position: relative;
          overflow: hidden;
        }
        
        .submit-btn::before {
          content: '';
          position: absolute;
          top: 0;
          left: -100%;
          width: 100%;
          height: 100%;
          background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
          transition: left 0.5s;
        }
        
        .submit-btn:hover:not(:disabled)::before {
          left: 100%;
        }
        
        .submit-btn:hover:not(:disabled) {
          transform: translateY(-3px);
          box-shadow: 0 20px 40px rgba(16, 185, 129, 0.4);
        }
        
        .submit-btn:disabled {
          background: #d1d5db;
          cursor: not-allowed;
          transform: none;
        }
        
        .spinner {
          width: 20px;
          height: 20px;
          border: 2px solid transparent;
          border-top: 2px solid white;
          border-radius: 50%;
          animation: spin 1s linear infinite;
        }
        
        .send-icon {
          font-size: 1.4rem;
        }
        
        .info-card {
          background: rgba(255, 255, 255, 0.95);
          backdrop-filter: blur(20px);
          border-radius: 20px;
          padding: 3rem;
          box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
          position: relative;
          z-index: 1;
          height: fit-content;
        }
        
        .card-header {
          text-align: center;
          margin-bottom: 2rem;
        }
        
        .card-header h2 {
          color: white;
          font-size: 2.2rem;
          margin-bottom: 1rem;
          background: linear-gradient(135deg, #10b981 0%, #059669 100%);
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
        }
        
        .decoration-line {
          width: 60px;
          height: 4px;
          background: linear-gradient(135deg, #10b981 0%, #059669 100%);
          margin: 0 auto;
          border-radius: 2px;
        }
        
        .contact-details {
          display: flex;
          flex-direction: column;
          gap: 2rem;
          margin-bottom: 2rem;
        }
        
        .contact-item {
          display: flex;
          align-items: flex-start;
          gap: 1.5rem;
        }
        
        .icon-wrapper {
          background: linear-gradient(135deg, #10b981 0%, #059669 100%);
          padding: 1rem;
          border-radius: 12px;
          display: flex;
          align-items: center;
          justify-content: center;
          min-width: 60px;
          height: 60px;
        }
        
        .icon {
          font-size: 1.8rem;
        }
        
        .contact-text h3 {
          color: #374151;
          margin-bottom: 0.5rem;
          font-size: 1.2rem;
        }
        
        .contact-text p {
          color: #6b7280;
          line-height: 1.6;
        }
        
        .map-container {
          border-radius: 12px;
          overflow: hidden;
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .map-container iframe {
          width: 100%;
          height: 200px;
          border: none;
          display: block;
        }
        
        @keyframes spin {
          0% { transform: rotate(0deg); }
          100% { transform: rotate(360deg); }
        }
        
        @keyframes pulse {
          0%, 100% { opacity: 1; }
          50% { opacity: 0.5; }
        }
        
        @media (max-width: 1024px) {
          .contact-content {
            grid-template-columns: 1fr;
          }
          
          .contact-form-section {
            padding: 3rem 2rem;
          }
          
          .contact-info-section {
            padding: 3rem 2rem;
          }
        }
        
        @media (max-width: 768px) {
          .contact-page {
            padding: 1rem;
          }
          
          .contact-header h1 {
            font-size: 2.5rem;
          }
          
          .contact-item {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
          }
          
          .icon-wrapper {
            align-self: center;
          }
        }
      `}</style>
    </div>
  );
}

export default Contact;