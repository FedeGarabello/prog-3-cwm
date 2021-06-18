import {API_ENDPOINT} from "../env/env";

export const apiFetch = function(url, options = {}) {
    options['credentials'] = 'include';
    return fetch(`${API_ENDPOINT}${url}`, options)
        .then(res => res.json());
}