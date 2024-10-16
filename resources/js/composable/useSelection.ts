import { computed, ref } from "vue";

export default function useSelection() {
    const selection = ref<number[]>([]);

    const addToSelection = (wordId: number) => {
        if (!selection.value.includes(wordId)) {
            selection.value.push(wordId);
        }
    };

    const removeFromSelection = (wordId: number) => {
        selection.value = selection.value.filter(id => id !== wordId);
    };

    const toggleSelection = (wordId: number, event: MouseEvent | TouchEvent) => {
        if (event.ctrlKey || event.metaKey) { // Ctrl on Windows/Linux or Cmd on Mac
            // Allow multi-selection
            if (selection.value.includes(wordId)) {
                removeFromSelection(wordId);
            } else {
                addToSelection(wordId);
            }
        } else {
            // Single selection: Clear existing and select only the clicked word
            selection.value = [wordId];
        }
    };

    const clearSelection = () => {
        selection.value = [];
    }

    const isSelected = (wordId: number) => {
        return selection.value.includes(wordId);
    }

    return { selection, addToSelection, removeFromSelection, toggleSelection, clearSelection, isSelected };
}
