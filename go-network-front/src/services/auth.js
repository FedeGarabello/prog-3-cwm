
 import {apiFetch} from "../api/fetch.js";

let userData = {
    id: null,
    email: null,
};

/**
 * Objeto del servicio, contiene todos los métodos pertinentes.
 *
 * @type {{}}
 */
const authService = {
    /**
     * 
     *
     * @param {string} email
     * @param {string} password
     * @return {Promise<*>}
     */
    login(email, password) {
        return apiFetch('login', {
            method: 'POST',
            body: JSON.stringify({
                email,
                password,
            })
        })
            .then(response => {
                if(response.success) {
                    userData = {
                        id: response.data.id,
                        email
                    };

                    localStorage.setItem('userData', JSON.stringify(userData));
                }
                return response;
            });
    },

    /**
     *
     * @return {boolean}
     */
    isAuthenticated() {
        return userData.id !== null;
    },

    /**
     *
     */
    logout() {
        return apiFetch('logout', {
            method: 'POST',
        }).then(res => {
            console.log(res)
            userData = {
                id: null,
                email: null,
            };
            localStorage.removeItem('userData');
            return true;
        });
    },

    /**
     *
     * @return {{usuario: null, id: null, email: null}}
     */
    getUserData() {
        return {
            ...userData
        };
    },
};

if(localStorage.getItem('userData') !== null) {
    userData = JSON.parse(localStorage.getItem('userData'));
}

export default authService;
