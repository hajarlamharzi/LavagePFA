import React, { useState, useEffect } from 'react';
import api, { getCsrfToken } from '../services/api';

function Reservation() {
  const [formData, setFormData] = useState({
    nom: '',
    email: '',
    telephone: '',
    type_vehicule: '',
    services: [],
    date_reservation: '',
    heure_reservation: '',
    remarque: '',
  });

  const [servicesList] = useState([
    { id: 1, title: 'Lavage Intérieur', description: 'Nettoyage complet de l\'intérieur du véhicule' },
    { id: 2, title: 'Lavage Extérieur', description: 'Nettoyage approfondi de la carrosserie' },
    { id: 3, title: 'Lavage Premium', description: 'Service complet intérieur + extérieur' },
    { id: 4, title: 'Cire et Protection', description: 'Application de cire protectrice' },
    { id: 5, title: 'Nettoyage Jantes', description: 'Nettoyage spécial des jantes et pneus' },
  ]);

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

  const handleServiceChange = (id) => {
    setFormData(prev => ({
      ...prev,
      services: prev.services.includes(id)
        ? prev.services.filter(s => s !== id)
        : [...prev.services, id]
    }));
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

    if (!formData.type_vehicule) {
      setError('Veuillez sélectionner un type de véhicule');
      return;
    }

    if (formData.services.length === 0) {
      setError('Veuillez sélectionner au moins un service');
      return;
    }

    if (!formData.date_reservation || !formData.heure_reservation) {
      setError('Veuillez sélectionner une date et une heure');
      return;
    }

    setLoading(true);
    setError('');
    setSuccess(false);

    try {
      const submissionData = {
        nom: formData.nom,
        email: formData.email,
        telephone: formData.telephone,
        type_vehicule: formData.type_vehicule,
        date_reservation: formData.date_reservation,
        heure_reservation: formData.heure_reservation,
        type_lavage: formData.services.map(id => servicesList.find(s => s.id === id)?.title).join(', '),
        remarque: formData.remarque,
      };

      console.log('📤 Data envoyée:', submissionData);

      const response = await api.post('/api/reservations', submissionData, {
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        withCredentials: true
      });

      console.log('✅ Réponse du serveur:', response.data);
      
      setSuccess(true);
      setFormData({
        nom: '',
        email: '',
        telephone: '',
        type_vehicule: '',
        services: [],
        date_reservation: '',
        heure_reservation: '',
        remarque: '',
      });

    } catch (err) {
      console.error('❌ Erreur complète:', err);
      console.error('❌ Réponse d\'erreur:', err.response?.data);
      
      if (err.response?.data?.errors) {
        const messages = Object.values(err.response.data.errors).flat();
        setError('Erreurs de validation: ' + messages.join(', '));
      } else {
        setError(err.response?.data?.message || 'Erreur lors de l\'envoi de la réservation');
      }
    } finally {
      setLoading(false);
    }
  };

  const getConnectionStatus = () => {
    if (initializing) return '🔄 Initialisation...';
    return appInitialized ? '✅ Connecté au serveur' : '❌ Hors ligne';
  };

  const calculateTotal = () => {
    const basePrice = 50;
    const servicePrice = formData.services.length * 20;
    const vehicleMultiplier = formData.type_vehicule === 'suv' ? 1.3 : formData.type_vehicule === 'utilitaire' ? 1.5 : 1;
    return (basePrice + servicePrice) * vehicleMultiplier;
  };

  return (
    <div className="reservation-page">
      <div className="reservation-container">
        <div className="reservation-content">
          <div className="reservation-form-section">
            <div className="reservation-header">
              <h1>Réserver un Lavage</h1>
              <p>Planifiez votre lavage en quelques clics</p>
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
                Réservation envoyée avec succès ! Nous vous confirmons rapidement.
              </div>
            )}
            
            {error && (
              <div className="error-message">
                <span className="error-icon">❌</span>
                {error}
              </div>
            )}

            <form onSubmit={handleSubmit} className="reservation-form">
              <div className="form-row">
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
              </div>

              <div className="form-row">
                <div className="form-group">
                  <label htmlFor="telephone">Téléphone</label>
                  <input
                    type="tel"
                    id="telephone"
                    name="telephone"
                    value={formData.telephone}
                    onChange={handleChange}
                    required
                    disabled={loading}
                    placeholder="+212 6 12 34 56 78"
                  />
                </div>

                <div className="form-group">
                  <label htmlFor="type_vehicule">Type de véhicule</label>
                  <select 
                    name="type_vehicule" 
                    value={formData.type_vehicule} 
                    onChange={handleChange} 
                    required 
                    disabled={loading}
                  >
                    <option value="">Sélectionnez un type</option>
                    <option value="voiture">Voiture</option>
                    <option value="suv">SUV/4x4</option>
                    <option value="utilitaire">Véhicule utilitaire</option>
                  </select>
                </div>
              </div>

              <div className="form-group">
                <label className="services-label">Services sélectionnés</label>
                <div className="services-grid">
                  {servicesList.map(service => (
                    <label key={service.id} className="service-card">
                      <input 
                        type="checkbox" 
                        checked={formData.services.includes(service.id)} 
                        onChange={() => handleServiceChange(service.id)} 
                        disabled={loading} 
                        className="service-checkbox"
                      />
                      <div className="service-content">
                        <span className="service-title">{service.title}</span>
                        <span className="service-description">{service.description}</span>
                        <span className="service-price">+20 DH</span>
                      </div>
                    </label>
                  ))}
                </div>
              </div>

              <div className="form-row">
                <div className="form-group">
                  <label htmlFor="date_reservation">Date de réservation</label>
                  <input 
                    type="date" 
                    name="date_reservation" 
                    value={formData.date_reservation} 
                    onChange={handleChange} 
                    required 
                    disabled={loading} 
                    min={new Date().toISOString().split('T')[0]}
                  />
                </div>

                <div className="form-group">
                  <label htmlFor="heure_reservation">Heure de réservation</label>
                  <input 
                    type="time" 
                    name="heure_reservation" 
                    value={formData.heure_reservation} 
                    onChange={handleChange} 
                    required 
                    disabled={loading}
                    min="08:00"
                    max="20:00"
                  />
                </div>
              </div>

              <div className="form-group">
                <label htmlFor="remarque">Remarques supplémentaires</label>
                <textarea
                  id="remarque"
                  name="remarque"
                  value={formData.remarque}
                  onChange={handleChange}
                  disabled={loading}
                  rows="3"
                  placeholder="Informations supplémentaires sur votre véhicule ou demande spéciale..."
                />
              </div>

              <div className="reservation-summary">
                <div className="summary-item">
                  <span>Prix de base:</span>
                  <span>50 DH</span>
                </div>
                <div className="summary-item">
                  <span>Services supplémentaires:</span>
                  <span>{formData.services.length * 20} DH</span>
                </div>
                <div className="summary-item total">
                  <span>Total estimé:</span>
                  <span>{calculateTotal().toFixed(0)} DH</span>
                </div>
              </div>

              <button 
                type="submit" 
                disabled={loading || !appInitialized}
                className="submit-btn"
              >
                {loading ? (
                  <>
                    <span className="spinner"></span>
                    Réservation en cours...
                  </>
                ) : !appInitialized ? (
                  '📡 Connexion requise'
                ) : (
                  <>
                    <span className="reserve-icon">📅</span>
                    Confirmer la réservation
                  </>
                )}
              </button>
            </form>
          </div>

          <div className="reservation-info-section">
            <div className="info-card">
              <div className="card-header">
                <h2>Informations importantes</h2>
                <div className="decoration-line"></div>
              </div>
              
              <div className="info-details">
                <div className="info-item">
                  <div className="icon-wrapper">
                    <span className="icon">⏰</span>
                  </div>
                  <div className="info-text">
                    <h3>Durée estimée</h3>
                    <p>30-60 minutes selon les services</p>
                  </div>
                </div>

                <div className="info-item">
                  <div className="icon-wrapper">
                    <span className="icon">💧</span>
                  </div>
                  <div className="info-text">
                    <h3>Éco-responsable</h3>
                    <p>Nous utilisons des produits biodégradables</p>
                  </div>
                </div>

                <div className="info-item">
                  <div className="icon-wrapper">
                    <span className="icon">🚗</span>
                  </div>
                  <div className="info-text">
                    <h3>Service complet</h3>
                    <p>Prise en charge de tous types de véhicules</p>
                  </div>
                </div>

                <div className="info-item">
                  <div className="icon-wrapper">
                    <span className="icon">📞</span>
                  </div>
                  <div className="info-text">
                    <h3>Confirmation</h3>
                    <p>Vous recevrez un SMS de confirmation</p>
                  </div>
                </div>
              </div>

              <div className="schedule-info">
                <h3>Horaires d'ouverture</h3>
                <div className="schedule-times">
                  <div className="time-slot">
                    <span>Lun - Sam:</span>
                    <span>8h00 - 20h00</span>
                  </div>
                  <div className="time-slot">
                    <span>Dimanche:</span>
                    <span>9h00 - 18h00</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <style jsx>{`
        .reservation-page {
          min-height: 100vh;
          background: linear-gradient(135deg, #10b981 0%, #059669 100%);
          padding: 2rem;
          font-family: 'Inter', 'Segoe UI', sans-serif;
        }
        
        .reservation-container {
          max-width: 1400px;
          margin: 0 auto;
          background: rgba(255, 255, 255, 0.95);
          backdrop-filter: blur(20px);
          border-radius: 24px;
          overflow: hidden;
          box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
        }
        
        .reservation-content {
          display: grid;
          grid-template-columns: 1.2fr 0.8fr;
          min-height: 800px;
        }
        
        .reservation-form-section {
          padding: 3rem;
          background: white;
          overflow-y: auto;
          max-height: 100vh;
        }
        
        .reservation-info-section {
          background: linear-gradient(135deg, #10b981 0%, #059669 100%);
          padding: 3rem;
          display: flex;
          align-items: center;
          justify-content: center;
          position: relative;
          overflow: hidden;
        }
        
        .reservation-info-section::before {
          content: '';
          position: absolute;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
        }
        
        .reservation-header {
          text-align: center;
          margin-bottom: 2rem;
        }
        
        .reservation-header h1 {
          font-size: 2.5rem;
          color: #2c3e50;
          margin-bottom: 0.5rem;
          font-weight: 700;
          background: linear-gradient(135deg, #10b981 0%, #059669 100%);
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
        }
        
        .reservation-header p {
          color: #7f8c8d;
          font-size: 1.1rem;
          font-weight: 300;
        }
        
        .connection-status {
          display: flex;
          align-items: center;
          gap: 1rem;
          padding: 1rem;
          border-radius: 12px;
          margin-bottom: 1rem;
          font-weight: 600;
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
          width: 10px;
          height: 10px;
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
          padding: 0.8rem;
          border-radius: 8px;
          font-size: 0.8rem;
          margin-bottom: 1rem;
          border-left: 4px solid #10b981;
          display: flex;
          align-items: center;
          gap: 0.5rem;
          color: #4b5563;
        }
        
        .connection-warning {
          background: rgba(251, 191, 36, 0.1);
          border: 1px solid rgba(251, 191, 36, 0.3);
          padding: 1rem;
          border-radius: 12px;
          margin-bottom: 1rem;
          text-align: center;
        }
        
        .test-connection-btn {
          background: linear-gradient(135deg, #10b981 0%, #059669 100%);
          color: white;
          border: none;
          padding: 0.8rem 1.5rem;
          border-radius: 8px;
          cursor: pointer;
          font-weight: 600;
          transition: all 0.3s ease;
          margin-top: 0.5rem;
        }
        
        .success-message, .error-message {
          padding: 1rem;
          border-radius: 12px;
          margin-bottom: 1rem;
          display: flex;
          align-items: center;
          gap: 0.5rem;
          font-weight: 600;
        }
        
        .success-message {
          background: rgba(72, 187, 120, 0.1);
          color: #155724;
          border: 1px solid rgba(72, 187, 120, 0.3);
        }
        
        .error-message {
          background: rgba(245, 101, 101, 0.1);
          color: #721c24;
          border: 1px solid rgba(245, 101, 101, 0.3);
        }
        
        .reservation-form {
          display: flex;
          flex-direction: column;
          gap: 1.5rem;
        }
        
        .form-row {
          display: grid;
          grid-template-columns: 1fr 1fr;
          gap: 1rem;
        }
        
        .form-group {
          display: flex;
          flex-direction: column;
        }
        
        .form-group label {
          margin-bottom: 0.5rem;
          color: #374151;
          font-weight: 600;
          font-size: 0.9rem;
        }
        
        .services-label {
          font-size: 1.1rem !important;
          margin-bottom: 1rem !important;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
          padding: 0.8rem;
          border: 2px solid #e5e7eb;
          border-radius: 8px;
          font-size: 0.9rem;
          transition: all 0.3s ease;
          background: #f9fafb;
          font-family: inherit;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
          outline: none;
          border-color: #10b981;
          background: white;
          box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }
        
        .services-grid {
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
          gap: 0.8rem;
          margin-top: 0.5rem;
        }
        
        .service-card {
          display: flex;
          align-items: center;
          padding: 0.8rem;
          border: 2px solid #e5e7eb;
          border-radius: 8px;
          cursor: pointer;
          transition: all 0.3s ease;
          background: #f9fafb;
        }
        
        .service-card:hover {
          border-color: #10b981;
          transform: translateY(-2px);
        }
        
        .service-checkbox {
          margin-right: 0.8rem;
          transform: scale(1.2);
        }
        
        .service-content {
          flex: 1;
          display: flex;
          flex-direction: column;
        }
        
        .service-title {
          font-weight: 600;
          color: #374151;
          margin-bottom: 0.2rem;
        }
        
        .service-description {
          font-size: 0.8rem;
          color: #6b7280;
          margin-bottom: 0.3rem;
        }
        
        .service-price {
          font-size: 0.9rem;
          font-weight: 600;
          color: #10b981;
        }
        
        .service-card input:checked + .service-content {
          color: #10b981;
        }
        
        .service-card input:checked {
          background-color: #10b981;
          border-color: #10b981;
        }
        
        .reservation-summary {
          background: #f8f9fa;
          padding: 1rem;
          border-radius: 8px;
          border: 1px solid #e9ecef;
        }
        
        .summary-item {
          display: flex;
          justify-content: space-between;
          margin-bottom: 0.5rem;
          color: #495057;
        }
        
        .summary-item.total {
          font-weight: 700;
          font-size: 1.1rem;
          color: #10b981;
          border-top: 1px solid #dee2e6;
          padding-top: 0.5rem;
          margin-top: 0.5rem;
        }
        
        .submit-btn {
          background: linear-gradient(135deg, #10b981 0%, #059669 100%);
          color: white;
          border: none;
          padding: 1rem 2rem;
          border-radius: 8px;
          font-size: 1.1rem;
          font-weight: 600;
          cursor: pointer;
          transition: all 0.3s ease;
          display: flex;
          align-items: center;
          justify-content: center;
          gap: 0.5rem;
          margin-top: 1rem;
        }
        
        .submit-btn:hover:not(:disabled) {
          transform: translateY(-2px);
          box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        }
        
        .submit-btn:disabled {
          background: #d1d5db;
          cursor: not-allowed;
          transform: none;
        }
        
        .spinner {
          width: 18px;
          height: 18px;
          border: 2px solid transparent;
          border-top: 2px solid white;
          border-radius: 50%;
          animation: spin 1s linear infinite;
        }
        
        .info-card {
          background: rgba(255, 255, 255, 0.95);
          backdrop-filter: blur(20px);
          border-radius: 20px;
          padding: 2rem;
          box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
          position: relative;
          z-index: 1;
        }
        
        .card-header {
          text-align: center;
          margin-bottom: 1.5rem;
        }
        
        .card-header h2 {
          font-size: 1.8rem;
          margin-bottom: 0.5rem;
          background: linear-gradient(135deg, #10b981 0%, #059669 100%);
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
        }
        
        .decoration-line {
          width: 50px;
          height: 3px;
          background: linear-gradient(135deg, #10b981 0%, #059669 100%);
          margin: 0 auto;
          border-radius: 2px;
        }
        
        .info-details {
          display: flex;
          flex-direction: column;
          gap: 1rem;
          margin-bottom: 1.5rem;
        }
        
        .info-item {
          display: flex;
          align-items: center;
          gap: 1rem;
        }
        
        .icon-wrapper {
          background: linear-gradient(135deg, #10b981 0%, #059669 100%);
          padding: 0.8rem;
          border-radius: 10px;
          display: flex;
          align-items: center;
          justify-content: center;
          min-width: 50px;
          height: 50px;
        }
        
        .icon {
          font-size: 1.4rem;
        }
        
        .info-text h3 {
          color: #374151;
          margin-bottom: 0.2rem;
          font-size: 1rem;
        }
        
        .info-text p {
          color: #6b7280;
          font-size: 0.9rem;
        }
        
        .schedule-info {
          background: #f8f9fa;
          padding: 1rem;
          border-radius: 8px;
        }
        
        .schedule-info h3 {
          color: #374151;
          margin-bottom: 0.5rem;
          text-align: center;
        }
        
        .time-slot {
          display: flex;
          justify-content: space-between;
          margin-bottom: 0.3rem;
          color: #495057;
          font-size: 0.9rem;
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
          .reservation-content {
            grid-template-columns: 1fr;
          }
          
          .reservation-form-section {
            padding: 2rem;
          }
          
          .reservation-info-section {
            padding: 2rem;
          }
        }
        
        @media (max-width: 768px) {
          .reservation-page {
            padding: 1rem;
          }
          
          .reservation-header h1 {
            font-size: 2rem;
          }
          
          .form-row {
            grid-template-columns: 1fr;
          }
          
          .services-grid {
            grid-template-columns: 1fr;
          }
          
          .info-item {
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
          }
        }
      `}</style>
    </div>
  );
}

export default Reservation;