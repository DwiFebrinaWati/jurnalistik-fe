const BASE_URL = 'https://jurnalsmandas.web.id/api';

async function callAPI(endpoint, method = 'GET', bodyData = null) {
    const token = localStorage.getItem('auth_token');

    const headers = {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    };

    if (token) {
        headers['Authorization'] = `Bearer ${token}`;
    }

    const config = {
        method: method,
        headers: headers
    };

    if (bodyData) {
        config.body = JSON.stringify(bodyData);
    }

    try {
        const response = await fetch(`${BASE_URL}${endpoint}`, config);

        if (response.status === 401) {
            localStorage.removeItem('auth_token');
            window.location.href = 'login.html';
            return;
        }

        return await response.json();
    } catch (error) {
        console.error("Koneksi Error:", error);
        throw error;
    }
}
