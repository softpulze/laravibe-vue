import { Nullable } from '@/types';

export type FlashActionType = 'copy' | 'redirect';

export type FlashType = 'error' | 'success' | 'warning' | 'info';

export interface FlashAction {
    type: FlashActionType;
    payload: string;
    label?: Nullable<string>;
}

export interface Flash {
    type: FlashType;
    message: string;
    actions?: FlashAction[];
}
