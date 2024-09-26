export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string | null;
}

export interface Permissions {
    word: {
        update: boolean;
    };
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
        permissions: Permissions; // Adding permissions to the auth structure
    };
};
