// server.js
import express from 'express';
import flightRoutes from './routes/flightRoutes.js';
import { errorHandler } from './middlewares/index.js';
import { appConfig } from './config/appConfig.js';

const app = express();

// Global middleware
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Public route
app.get('/', (req, res) => {
    res.send('Welcome to the Airport!');
});

// Flight routes
app.use(flightRoutes);

// Error handling middleware
app.use(errorHandler);

// Start server
app.listen(appConfig.PORT, () => {
    console.log(`🚀 Server running at http://localhost:${appConfig.PORT}`);
});
