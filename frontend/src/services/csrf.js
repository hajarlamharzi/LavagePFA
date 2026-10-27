import axios from "axios";

export const getCsrfToken = async () => {
  try {
    // appel direct au backend (racine), withCredentials = true pour set cookie
    await axios.get("http://localhost:8000/sanctum/csrf-cookie", { withCredentials: true });
    return true;
  } catch (err) {
    console.warn("getCsrfToken failed (ok if not using Sanctum):", err.message);
    return false;
  }
};
