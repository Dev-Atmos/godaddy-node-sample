// controllers/flightController.js
export const getEventLoop = (req, res) => {

    process.nextTick(() => console.log('NextTick'));
    console.log('Start');

    setTimeout(() => console.log('Timeout'), 0);
    setImmediate(() => console.log('Immediate'));

    function heavyTask() {
        let i = 0;
        function chunk() {
            for (let j = 0; j < 1e6 && i < 1e9; j++, i++) {
                
            }
            if (i < 1e9) setTimeout(chunk, 0); // Yield control
        }
        chunk();
    }
    console.log('End');
    res.json({ message: `Welcome aboard` });
};
