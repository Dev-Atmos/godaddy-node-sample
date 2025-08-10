// config/appConfig.js
export const appConfig = {
    PORT: process.env.PORT || 3000,
    VALID_TOKEN: 'valid-token' // in production, load from process.env
};
