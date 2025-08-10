// middlewares/errorHandler.js
export const errorHandler = (err, req, res, next) => {
    console.error(`❌ Error: ${err.message || err}`);
    res.status(err.status || 500).json({
        error: err.message || 'Internal Server Error',
    });
};
