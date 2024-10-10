declare module "@inertiajs/inertia-vue3" {
    export interface Jetstream {
        canCreateTeams: boolean;
        canManageTwoFactorAuthentication: boolean;
        canUpdatePassword: boolean;
        canUpdateProfileInformation: boolean;
        hasEmailVerification: boolean;
        flash: any[];
        hasAccountDeletionFeatures: boolean;
        hasApiFeatures: boolean;
        hasTeamFeatures: boolean;
        hasTermsAndPrivacyPolicyFeature: boolean;
        managesProfilePhotos: boolean;
    }
    export interface Errors {}
    export interface Flash {
        message: {
            type: string;
            body: string;
            closeable: boolean;
            action: Action;
        };
    }

    interface PageProps {
        jetstream: Jetstream;
        user: User;
        errorBags: any[];
        errors: Errors;
        auth: {
            user: User;
        };
        flash: Flash;
        queryParams: any[];
        ziggy: Ziggy;
        url: string;
        socials: any[];
        notifications: any[];
        reportOptions: any[];
        locale: TLocale;
        greetings: Transferable;
        distanceInvitationLimit: number;
        maximumUploadNumberOfFiles: string;
        players: Players;
        positions: Positions;
        countries: Countries;
        advertisements: any[];
    }
}
