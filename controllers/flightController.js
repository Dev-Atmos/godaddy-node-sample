// controllers/flightController.js
export const getFlight = (req, res) => {
    res.json({ message: `Welcome aboard, ${req.query.name}!` });
};
