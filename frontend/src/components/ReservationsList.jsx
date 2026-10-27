import React, { useState, useEffect } from 'react';
import api from '../services/api';
import './ReservationsList.css';

const ReservationList = () => {
  const [reservations, setReservations] = useState([]);
  const [filters, setFilters] = useState({
    date: '',
    type_lavage: ''
  });
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  useEffect(() => {
    fetchReservations();
  }, [filters]);

  const fetchReservations = async () => {
    try {
      setLoading(true);
      const params = new URLSearchParams();
      
      if (filters.date) params.append('date', filters.date);
      if (filters.type_lavage) params.append('type_lavage', filters.type_lavage);
      
      const response = await api.get(`/api/reservations?${params.toString()}`);
      setReservations(response.data.data || response.data);
    } catch (error) {
      console.error('Erreur lors du chargement des réservations:', error);
      setError('Impossible de charger les réservations');
    } finally {
      setLoading(false);
    }
  };

  const handleFilterChange = (e) => {
    const { name, value } = e.target;
    setFilters({
      ...filters,
      [name]: value
    });
  };

  const resetFilters = () => {
    setFilters({
      date: '',
      type_lavage: ''
    });
  };

  if (loading) {
    return (
      <div className="reservations-container">
        <div className="text-center">
          <div className="spinner-border text-primary" role="status">
            <span className="visually-hidden">Chargement...</span>
          </div>
        </div>
      </div>
    );
  }

  return (
    <div className="reservations-container">
      <h2 className="reservations-title">
        <i className="bi bi-calendar-event-fill me-2"></i> Gestion des Réservations Clients
      </h2>

      {/* Filtres */}
      <form className="filters-card">
        <div className="filters-row">
          <div className="filter-group">
            <label className="form-label">Date</label>
            <input 
              type="date" 
              name="date" 
              value={filters.date} 
              onChange={handleFilterChange} 
              className="form-control" 
            />
          </div>
          
          <div className="filter-group">
            <label className="form-label">Type de lavage</label>
            <select 
              name="type_lavage" 
              value={filters.type_lavage} 
              onChange={handleFilterChange} 
              className="form-select"
            >
              <option value="">-- Tous --</option>
              <option value="express">Express</option>
              <option value="complet">Complet</option>
              <option value="intérieur">Intérieur</option>
              <option value="extérieur">Extérieur</option>
              <option value="moteur">Moteur</option>
            </select>
          </div>
          
          <div className="filter-actions">
            <button type="button" onClick={fetchReservations} className="btn btn-outline-primary">
              <i className="bi bi-funnel-fill"></i> Filtrer
            </button>
            <button type="button" onClick={resetFilters} className="btn btn-outline-secondary">
              <i className="bi bi-x-circle"></i> Réinitialiser
            </button>
          </div>
        </div>
      </form>

      {error && (
        <div className="alert alert-danger">
          <i className="bi bi-exclamation-triangle-fill me-2"></i> {error}
        </div>
      )}

      {reservations.length === 0 ? (
        <div className="alert alert-warning text-center">Aucune réservation trouvée.</div>
      ) : (
        <>
          <div className="table-responsive">
            <table className="reservations-table">
              <thead>
                <tr>
                  <th>Client</th>
                  <th>Email</th>
                  <th>Téléphone</th>
                  <th>Date</th>
                  <th>Heure</th>
                  <th>Type Lavage</th>
                  <th>Remarque</th>
                </tr>
              </thead>
              <tbody>
                {reservations.map((reservation) => (
                  <tr key={reservation.id}>
                    <td>{reservation.nom}</td>
                    <td>{reservation.email}</td>
                    <td>{reservation.telephone}</td>
                    <td>{new Date(reservation.date).toLocaleDateString()}</td>
                    <td>{reservation.heure}</td>
                    <td>
                      <span className="badge bg-info">
                        {reservation.type_lavage.charAt(0).toUpperCase() + reservation.type_lavage.slice(1)}
                      </span>
                    </td>
                    <td>{reservation.remarque || '-'}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
          
          {/* Pagination (si votre API retourne des données paginées) */}
          {/* <div className="pagination-container">
            <Pagination>
              <Pagination.Prev />
              <Pagination.Item>{1}</Pagination.Item>
              <Pagination.Next />
            </Pagination>
          </div> */}
        </>
      )}
    </div>
  );
};

export default ReservationList;