import React from 'react';
import LavagesSelection from '../components/LavagesSelection'; // Remarque le chemin relatif

const lavagesData = [
  { id: 1, type_lavage: 'lavage moteur', prix: 150 },
  { id: 2, type_lavage: 'lavage intérieur', prix: 100 },
  { id: 3, type_lavage: 'lavage extérieur', prix: 80 },
  { id: 4, type_lavage: 'lavage complet', prix: 200 },
];

export default function PageLavage() {
  const typeVehicule = 'voiture_personnelle';

  const handleSelectionChange = (selectedIds) => {
    console.log('Lavages sélectionnés:', selectedIds);
  };

  return <LavagesSelection typeVehicule={typeVehicule} lavages={lavagesData} onSelectionChange={handleSelectionChange} />;
}
