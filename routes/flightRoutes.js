// routes/flightRoutes.js
import { Router } from 'express';
import { authMiddleware, validationMiddleware } from '../middlewares/index.js';
import { getFlight } from '../controllers/flightController.js';

const router = Router();

router.get('/flight', authMiddleware, validationMiddleware, getFlight);

export default router;
