import axios from 'axios';
import router from '../Router';
import {useAuthStore} from "@/Stores/Auth.js";

const csrfToken = document.head.querySelector('meta[name="csrf-token"]');

const http_axios = axios.create({
    baseURL: (import.meta.env.VITE_BASE_URL || '/')+'api/',
    headers: {
        'X-CSRF-TOKEN': csrfToken.content,
        "Content-type": "application/json",
        "Access-Control-Allow-Origin": "*",
    },
});

http_axios.interceptors.request.use((request) => {
    const userStore = useAuthStore()

    if(userStore.getToken()) {
        request.headers.Authorization = 'Bearer ' + userStore.getToken()
    }

    return request;
})





export default http_axios;
