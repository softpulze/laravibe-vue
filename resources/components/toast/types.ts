export type ToastActionType = 'copy' | 'redirect';

export type ToastType = 'error' | 'success' | 'warning' | 'info';

export interface ToastActionPayload {
    type: ToastActionType;
    payload: string;
    label?: string | null;
}

export interface ToastPayload {
    type: ToastType;
    message: string;
    actions?: ToastActionPayload[];
}
