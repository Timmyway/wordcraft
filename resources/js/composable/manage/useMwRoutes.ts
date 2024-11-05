import { useWordStore } from "@/store/wordStore";
import { usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";

interface MwRoute {
    label: string;
    icon: string;
    urls: string[];
    private: boolean;
}

export default function useMwRoutes() {
    const wordStore = useWordStore();
    const wordListOptions = {
        listMode: wordStore.setting.listMode,
        perPage: wordStore.setting.perPage,
    }
    const items = ref<MwRoute[]>([
        {
            label: 'Words',
            icon: 'fa fa-book',
            urls: [route('word.index', wordListOptions), route('word.add')],
            private: true
        },
        {
            label: 'Tags',
            icon: 'fa fa-tags',
            urls: [route('tag.index'), route('tag.add'), route('tag.detail'), route('tag.filter')],
            private: true
        },
        {
            label: 'MyLists',
            icon: 'fa fa-heart',
            urls: [route('playlist.index'), route('playlist.add'), route('playlist.detail')],
            private: true
        },
        {
            label: 'Irregular verbs',
            icon: 'fa fa-book-open',
            urls: [route('irregular-verb.index')],
            private: true
        },
        {
            label: 'Dashboard',
            icon: 'fa fa-user',
            urls: [route('dashboard')],
            private: true
        },
        {
            label: 'Help',
            icon: 'fa fa-question-circle',
            urls: [route('help')],
            private: true
        },
    ]);

    const page = usePage();

    const currentUrl = computed(() => {
        return page.url;
    })

    const getPath = (url: string) => new URL(url, window.location.origin).pathname;

    const isActive = (urls: string[]) => {
        const currentPath = getPath(currentUrl.value);
        return urls.some(url => getPath(url) === currentPath);
    };

    return { items, isActive }
}
