import { Nullable } from '.';

export interface User {
    id: number;

    name: string;
    email: string;

    avatar?: string;

    email_verified_at?: Nullable<string>;
    remember_token?: string;

    created_at?: string;
    updated_at?: string;
}
