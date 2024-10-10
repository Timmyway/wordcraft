import { Api } from "./Api";

export default {
    async search(q: string) {
        const params: { q: string } = {
            q,
        }
        try {
            return await Api.get('api/words/search', { params });
        } catch (error) {
            throw error;
        }
    },
    async unlock(payload: { ids: number[] }) {
        try {
            return await Api.post('api/words/unlock-many', payload);
        } catch (error) {
            throw error;
        }
    },
}
