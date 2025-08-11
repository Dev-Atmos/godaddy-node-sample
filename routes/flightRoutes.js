// routes/flightRoutes.js
import { Router } from 'express';
import { authMiddleware, validationMiddleware } from '../middlewares/index.js';
import { getFlight } from '../controllers/flightController.js';
import { getEventLoop} from '../controllers/eventController.js';

const router = Router();

router.get('/flight', authMiddleware, validationMiddleware, getFlight);
router.get('/event_loops',getEventLoop);

export default router;
