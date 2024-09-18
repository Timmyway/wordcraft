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
