export {};
declare global {
    export type StateName = "Free" | "Premium";
    export type State = `App\\Models\\States\\${StateName}`;
    export interface User {
        id: number;
        username: string;
        email: string;
        email_verified_at: Date | null;
        two_factor_confirmed_at: Date | null;
        current_team_id: null;
        profile_photo_path: null;
        joined_platform_at: Date;
        created_at: Date;
        updated_at: Date;
        country_id: number;
        club_id: number;
        position_id: number;
        first_name: string;
        last_name: string;
        phone: string;
        gender: "male" | "female";
        avatar: null | stirng;
        identity_issue_country: null;
        identity_type: null;
        identity_front_image: null;
        identity_back_image: null;
        identity_selfie_image: null;
        accepted_terms_and_conditions_version: null | string;
        accepted_privacy_policy_version: null;
        accepted_cookie_policy_version: null | string;
        date_of_birth: Date;
        identity_verified_at: Date | null;
        phone_verified_at: Date | null;
        accepted_terms_and_conditions_at: Date;
        accepted_privacy_policy_at: Date;
        accepted_cookie_policy_at: Date;
        preferred_foot: "right" | "left";
        rating: string;
        last_seen_at: Date;
        last_known_ip: string;
        current_country: string;
        current_region: string;
        current_city: string;
        current_latitude: string;
        current_longitude: string;
        locale: TLocale;
        state: State;
        geo_location: number;
        accepted_chat_regulations_at: Date | null;
        avatar_url: null | string;
        avatar_thumb_url: null | string;
        identity_front_image_url: null;
        identity_back_image_url: null;
        identity_selfie_image_url: null;
        has_verified_identity: boolean;
        age: number;
        name: Name;
        is_favorite: boolean;
        identity_status: string;
        state_name: StateName;
        played: number;
        missed: number;
        latest_conversation: Conversation | null;
        position: Position;
        media: TMedia[];
        favorites?: User[];
        pivot?: {
            user_id: number;
            favorite_id: number;
        };
        distance?: number;
        two_factor_enabled?: boolean;
    }
    export interface Conversation {
        id: number;
        created_at: Date;
        updated_at: Date;
        latest_message: Message;
        unread_messages: number;
        pivot: {
            user_id: number;
            conversation_id: number;
            is_deleted: number;
        };
    }
    export type Conversations = Conversation[];
    export interface Position {
        id: number;
        created_at: Date;
        updated_at: Date;
        name: Translatable;
        description: null;
    }
    export type Positions = Position[];

    export interface TMedia {
        id: number;
        model_type: string;
        model_id: number;
        uuid: string;
        collection_name: string;
        name: string;
        file_name: string;
        mime_type: string;
        disk: "public";
        conversions_disk: "public";
        size: number;
        manipulations: any[];
        custom_properties: any[];
        generated_conversions: {
            thumb: boolean;
        };
        responsive_images: any[];
        order_column: number;
        created_at: Date;
        updated_at: Date;
        suspended_at: null;
        original_url: string;
        preview_url: string;
        likes_count: number;
        is_liked: boolean;
    }
    export type TMedias = TMedia[];
    export interface Country {
        id: number;
        name: string;
        code: string;
        calling_code: string;
        created_at: Date;
        updated_at: Date;
        time_zone: string;
        flag: string;
        flag_thumb: string;
        media: TMedias;
    }
    export type Countries = Country[];
}
