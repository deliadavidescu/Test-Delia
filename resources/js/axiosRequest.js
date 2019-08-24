import axios from 'axios'

let token = document.head.querySelector('meta[name="csrf-token"]');

const headers = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': token.content
};


function httpRequest(method, url, request) {
    return axios[method](url, request, {headers: headers})
}

export default {
    get(url, request = null) {
        return httpRequest('get', url, request)
    },

    post(url, request = null) {
        return httpRequest('post', url, request)
    }
}
