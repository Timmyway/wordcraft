import { useConfirm } from "primevue/useconfirm";
import { router } from '@inertiajs/vue3';

export default function useDeleteConfirm(routeName: string, name='item') {
    const confirm = useConfirm();

    function deleteItem(id: number) {
        console.log('----------> Delete item: ', id)
        // Display delete confirm popup using Primevue
        return new Promise<void>((resolve) => {
            confirm.require({
                message: `Attention: la suppression de cet élément (${name}) est une action irréversible`,
                header: 'Supprimer',
                icon: 'fas fa-exclamation-triangle',
                accept: () => {
                    router.delete(route(routeName, id), {preserveScroll: true});
                    resolve();
                }
            });
        });
    }

    return { deleteItem }
}
