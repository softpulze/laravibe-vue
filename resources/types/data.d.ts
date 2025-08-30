import { Nullable } from '.';

export interface Breadcrumb {
    label: string;
    href: Nullable<string>;
}

export interface PageMeta {
    heading?: string;
    subheading?: string;

    title?: string;

    breadcrumbs?: Breadcrumb[];
}
