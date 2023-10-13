import axios from 'axios';
import { useAuthStore } from '../stores/authStore';

export const getSondage = async () => {
    const authStore = useAuthStore();
    const response = await axios.get(import.meta.env.VITE_API_BASE_URL+'sondage?user_id='+authStore.uid);

    return response.data ? response.data : [];
}