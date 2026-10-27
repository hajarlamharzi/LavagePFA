import React, { useState } from 'react';

function Login() {
  const [nom, setNom] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');

  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      const res = await fetch('http://localhost:8000/login', { // Laravel URL
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify({ nom, password }),
        credentials: 'include' // pour envoyer cookies/session
      });

      const data = await res.json();

      if (res.ok) {
        window.location.href = '/home'; // redirect après login
      } else {
        setError(data.message || 'Nom ou mot de passe invalide');
      }
    } catch (err) {
      console.error(err);
      setError('Erreur serveur');
    }
  };

  return (
    <form onSubmit={handleSubmit}>
      {error && <p style={{color:'red'}}>{error}</p>}
      <input value={nom} onChange={e => setNom(e.target.value)} placeholder="Nom" required />
      <input type="password" value={password} onChange={e => setPassword(e.target.value)} placeholder="Mot de passe" required />
      <button type="submit">Se connecter</button>
    </form>
  );
}

export default Login;
