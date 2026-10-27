import React, { useEffect, useState } from 'react';
import axios from 'axios';

function Home() {
  const [services, setServices] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    axios.get('http://localhost:8000/api/services')  // عدل الرابط على حسب مكان API ديالك
      .then(response => {
        setServices(response.data);
        setLoading(false);
      })
      .catch(error => {
        console.error('Erreur en récupérant les services:', error);
        setLoading(false);
      });
  }, []);

  return (
    <div>
      {/* Bannière */}
      <section 
  style={{ 
    backgroundColor: '#198754', // vert
    height: '400px',
    display: 'flex',
    flexDirection: 'column',
    justifyContent: 'center',
    alignItems: 'center',
    color: 'white',
    textAlign: 'center',
    padding: '0 1rem'
  }}
>
  <h1 style={{ fontSize: '3rem', fontWeight: 'bold', marginBottom: '1rem' }}>
    🌿 Green Car Wash 🌿
  </h1>
  <p style={{ fontSize: '1.5rem', marginBottom: '2rem' }}>
    Propreté, qualité et service premium pour votre véhicule
  </p>
  <a 
    href="/reservation" 
    style={{ 
      backgroundColor: 'white', 
      color: '#28a745', 
      padding: '0.8rem 2rem', 
      borderRadius: '5px', 
      fontWeight: 'bold', 
      textDecoration: 'none',
      fontSize: '1.2rem'
    }}
  >
    Réserver maintenant
  </a>
</section>

      {/* Aperçu dynamique des services */}
      <section style={{ padding: '2rem', textAlign: 'center' }}>
        <h2>Nos services rapides</h2>

        {loading ? (
          <p>Chargement des services...</p>
        ) : (
          <div style={{ display: 'flex', justifyContent: 'center', gap: '2rem', marginTop: '1rem' }}>
            {services.map(service => (
              <div key={service.id}>
                <h3>{service.title}</h3>
                <p>{service.description}</p>
              </div>
            ))}
          </div>
        )}
      </section>
    </div>
  );
}

export default Home;
