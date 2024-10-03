export interface DatatableColumn {
    id: string | number;
    name: string;
    label: string;
    type: string;
    classList?: string;
    width?: string;
    baseUrl?: string;
}

export type DatatableItem = {
    [key: string]: any
}

export type LayoutDirection = 'x' | 'y';

export type TailwindColor =
    | 'slate'
    | 'gray'
    | 'neutral'
    | 'zinc'
    | 'stone'
    | 'red'
    | 'orange'
    | 'amber'
    | 'yellow'
    | 'lime'
    | 'green'
    | 'emerald'
    | 'teal'
    | 'cyan'
    | 'sky'
    | 'blue'
    | 'indigo'
    | 'violet'
    | 'purple'
    | 'fuchsia'
    | 'pink'
    | 'rose';
