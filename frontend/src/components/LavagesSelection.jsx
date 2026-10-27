
import React, { useState } from 'react';

const iconeMap = {
  moteur: 'bi-gear-fill',
  intérieur: 'bi-house',
  extérieur: 'bi-sun',
  complet: 'bi-check-circle-fill',
};

export default function LavagesSelection({ typeVehicule, lavages, onSelectionChange }) {
  const [selectedIds, setSelectedIds] = useState(new Set());

  const toggleSelection = (id) => {
    const newSelected = new Set(selectedIds);
    if (newSelected.has(id)) {
      newSelected.delete(id);
    } else {
      newSelected.add(id);
    }
    setSelectedIds(newSelected);
    if (onSelectionChange) {
      onSelectionChange(Array.from(newSelected));
    }
  };

  const getIconClass = (typeLavage) => {
    for (const key in iconeMap) {
      if (typeLavage.toLowerCase().includes(key)) return iconeMap[key];
    }
    return 'bi-droplet-half';
  };

  if (!lavages || lavages.length === 0) {
    return (
      <div className="alert alert-warning text-center">
        <i className="bi bi-exclamation-triangle-fill"></i> Aucun type de lavage trouvé pour le véhicule sélectionné.
      </div>
    );
  }

  return (
    <div className="container mt-4">
      <h2 className="text-center mb-4">
        <i className="bi bi-car-front-fill"></i> Choisissez un type de lavage pour :{' '}
        <strong className="text-primary text-uppercase">{typeVehicule.replace('_', ' ')}</strong>
      </h2>

      <div className="row justify-content-center">
        {lavages.map((lavage) => (
          <div key={lavage.id} className="col-md-4 col-lg-4 mb-4">
            <div
              className={`card h-100 text-center shadow border-0 lavage-card ${
                selectedIds.has(lavage.id) ? 'selected' : ''
              }`}
              style={{ cursor: 'pointer' }}
              onClick={() => toggleSelection(lavage.id)}
            >
              <div className="card-body d-flex flex-column justify-content-between">
                <div>
                  <h5 className="card-title">
                    <i className={`bi ${getIconClass(lavage.type_lavage)} me-1`}></i>
                    {lavage.type_lavage.charAt(0).toUpperCase() + lavage.type_lavage.slice(1)}
                  </h5>
                  <p className="card-text text-success fs-4">
                    <i className="bi bi-currency-exchange"></i> {lavage.prix.toFixed(2)} MAD
                  </p>
                  <p className="text-muted">
                    <i className="bi bi-car-front"></i> {typeVehicule.replace('_', ' ')}
                  </p>
                </div>
              </div>
            </div>
          </div>
        ))}
      </div>

      <input type="hidden" value={Array.from(selectedIds).join(',')} />
    </div>
  );
}
