// src/App.js
import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';

import Navbar from './components/Navbar';

// Importe les pages (tu créeras ces composants plus tard)
import Accueil from './components/Accueil';
import Services from './components/Services';
import Offres from './components/Offres';
import About from './components/About';
import Contact from './components/Contact';
import Login from './components/Login';
import Reservation from './components/Reservation';

function App() {
  return (
    <Router>
      <Navbar />
        <Routes>
          <Route path="/" element={<Accueil />} />
          <Route path="/services" element={<Services />} />
          <Route path="/offres" element={<Offres />} />
          <Route path="/about" element={<About />} />
          <Route path="/contact" element={<Contact />} />
          <Route path="/login" element={<Login />} />
          <Route path="/reservation" element={<Reservation />} />
        </Routes>
    </Router>
  );
}

export default App;
