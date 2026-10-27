import axios from 'axios';

const API_BASE_URL = 'http://localhost:8000';

const api = axios.create({
  baseURL: API_BASE_URL,
  withCredentials: true,
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  },
});

let csrfTokenRetrieved = false;

export const getCsrfToken = async () => {
  try {
    await api.get('/sanctum/csrf-cookie');
    csrfTokenRetrieved = true;
    console.log('CSRF token récupéré avec succès');
  } catch (error) {
    console.error('Erreur lors de la récupération du CSRF token:', error);
    throw error;
  }
};

api.interceptors.request.use(
  async (config) => {
    if (['post', 'put', 'patch', 'delete'].includes(config.method.toLowerCase())) {
      if (!csrfTokenRetrieved) {
        await getCsrfToken();
      }
      
      const xsrfToken = document.cookie
        .split('; ')
        .find(row => row.startsWith('XSRF-TOKEN='))
        ?.split('=')[1];
      
      if (xsrfToken) {
        config.headers['X-XSRF-TOKEN'] = decodeURIComponent(xsrfToken);
      }
    }
    return config;
  },
  (error) => Promise.reject(error)
);

api.interceptors.response.use(
  (response) => response,
  async (error) => {
    const originalRequest = error.config;
    
    if (error.response?.status === 419 && !originalRequest._retry) {
      originalRequest._retry = true;
      console.warn('CSRF token expiré, renouvellement...');
      csrfTokenRetrieved = false;
      await getCsrfToken();
      return api(originalRequest);
    }
    
    return Promise.reject(error);
  }
);

export default api;