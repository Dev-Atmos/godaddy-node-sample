// middlewares/validation.js
export const validationMiddleware = (req, res, next) => {
    if (!req.query.name) {
        return next({ status: 400, message: 'Bad Request - name is required' });
    }
    console.log('✅ Validation passed');
    next();
};
