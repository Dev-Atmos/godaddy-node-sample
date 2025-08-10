// middlewares/auth.js
import { appConfig } from '../config/appConfig.js';

export const authMiddleware = (req, res, next) => {
    const token = req.headers['authorization'];
    if (!token || token !== appConfig.VALID_TOKEN) {
        return next({ status: 401, message: 'Unauthorized - Invalid Token' });
    }
    console.log('✅ Auth passed');
    next();
};
