import { AxiosStatic } from "axios";

export {};

declare global {
   declare interface Window {
      axios: AxiosStatic;
   }
   declare const axios: AxiosStatic;
}
