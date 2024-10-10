export {};
declare global {
    export type TLocale = "en" | "ar";
    export type Translatable = Record<TLocale, string>;
    export interface Resource<T> {
        data: T;
    }

    export interface PaginationMeta {
        current_page: number;
        from: number;
        last_page: number;
        links: Link[];
        path: string;
        per_page: number;
        to: number;
        total: number;
    }
    export interface Link {
        url: null | string;
        label: string;
        active: boolean;
    }
    export interface PaginationLinks {
        first: string;
        last: string;
        prev: null;
        next: null;
    }
    export interface PaginationData<T> {
        meta: PaginateMeta;
        links: PaginationLinks;
        data: T[];
    }
    export type DeepMerge<T, U> = Omit<T, keyof U> & U;

    type BasePrettifiedModel<T> = Pick<T, "id">;
    type ShouldBePrettified<T> =
        | BasePrettifiedModel<T>
        | BasePrettifiedModel<T>[];
    export type Prettify<T> = T extends (infer U)[]
        ? Prettify<U>[]
        : T extends ShouldBePrettified<T>
        ? {
              [K in keyof T]: T[K] extends ShouldBePrettified<T[K]>
                  ? Prettify<T[K]>
                  : T[K];
          }
        : T;
}
