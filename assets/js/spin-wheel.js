class SpinWheel {
    constructor(canvasId, discounts) {
        this.canvas = document.getElementById(canvasId);
        if (!this.canvas) {
            console.error("Canvas element not found!");
            return;
        }
        this.ctx = this.canvas.getContext('2d');
        this.discounts = discounts;
        this.colors = [
            '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4',
            '#FFEAA7', '#DDA0DD', '#98D8C8', '#F7B731'
        ];
        this.currentRotation = 0;
        this.spinning = false;
        this.size = 550;
        this.centerX = this.size / 2;
        this.centerY = this.size / 2;
        this.radius = 240;
        
        this.drawWheel();
    }
    
    drawWheel() {
        if (!this.ctx) return;
        
        const angleStep = (Math.PI * 2) / this.discounts.length;
        
        for(let i = 0; i < this.discounts.length; i++) {
            const startAngle = i * angleStep + this.currentRotation;
            const endAngle = (i + 1) * angleStep + this.currentRotation;
            
            this.ctx.beginPath();
            this.ctx.fillStyle = this.colors[i % this.colors.length];
            this.ctx.moveTo(this.centerX, this.centerY);
            this.ctx.arc(this.centerX, this.centerY, this.radius, startAngle, endAngle);
            this.ctx.fill();
            
            // Draw stroke
            this.ctx.strokeStyle = '#fff';
            this.ctx.lineWidth = 2;
            this.ctx.stroke();
            
            // Draw text
            this.ctx.save();
            this.ctx.translate(this.centerX, this.centerY);
            this.ctx.rotate(startAngle + angleStep / 2);
            this.ctx.fillStyle = '#fff';
            this.ctx.font = 'bold 24px "Poppins", Arial';
            this.ctx.shadowBlur = 0;
            const text = this.discounts[i] + '%';
            const textWidth = this.ctx.measureText(text).width;
            this.ctx.fillText(text, this.radius / 1.8, 15);
            this.ctx.restore();
        }
        
        // Draw inner circle
        this.ctx.beginPath();
        this.ctx.arc(this.centerX, this.centerY, 60, 0, Math.PI * 2);
        this.ctx.fillStyle = '#fff';
        this.ctx.fill();
        this.ctx.strokeStyle = '#0700C4';
        this.ctx.lineWidth = 4;
        this.ctx.stroke();
        
        // Draw inner decorative circle
        this.ctx.beginPath();
        this.ctx.arc(this.centerX, this.centerY, 50, 0, Math.PI * 2);
        this.ctx.fillStyle = '#0700C4';
        this.ctx.fill();
    }
    
    spin(callback) {
        if(this.spinning) return;
        
        this.spinning = true;
        const spinDuration = 3000;
        const spinStart = performance.now();
        const startRotation = this.currentRotation;
        const spins = Math.random() * 10 + 20;
        const targetRotation = startRotation + (spins * Math.PI * 2);
        
        const animate = (now) => {
            const elapsed = now - spinStart;
            const progress = Math.min(1, elapsed / spinDuration);
            const easeOut = 1 - Math.pow(1 - progress, 3);
            
            this.currentRotation = startRotation + (targetRotation - startRotation) * easeOut;
            this.drawWheel();
            
            if(progress < 1) {
                requestAnimationFrame(animate);
            } else {
                // Calculate winning segment
                const finalAngle = this.currentRotation % (Math.PI * 2);
                const angleStep = (Math.PI * 2) / this.discounts.length;
                let winningIndex = Math.floor(((Math.PI * 2) - finalAngle) / angleStep) % this.discounts.length;
                
                const discount = this.discounts[winningIndex];
                this.spinning = false;
                callback(discount);
            }
        };
        
        requestAnimationFrame(animate);
    }
}