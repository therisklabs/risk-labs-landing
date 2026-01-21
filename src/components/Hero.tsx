import { Button } from "@/components/ui/button";
import { ArrowRight, ShieldCheck } from "lucide-react";

const Hero = () => {
  return (
    <section className="relative min-h-screen overflow-hidden bg-hero pt-16">
      {/* Background glow effect */}
      <div className="absolute inset-0 bg-glow opacity-60 animate-glow-pulse" />
      
      {/* Grid pattern overlay */}
      <div 
        className="absolute inset-0 opacity-[0.03]"
        style={{
          backgroundImage: `linear-gradient(hsl(var(--foreground)) 1px, transparent 1px),
                           linear-gradient(90deg, hsl(var(--foreground)) 1px, transparent 1px)`,
          backgroundSize: '60px 60px'
        }}
      />

      <div className="container relative mx-auto flex min-h-[calc(100vh-4rem)] flex-col items-center justify-center px-6 text-center">
        <div className="mb-6 inline-flex items-center gap-2 rounded-full border border-primary/30 bg-primary/10 px-4 py-2 opacity-0 animate-fade-up" style={{ animationDelay: '0.1s' }}>
          <ShieldCheck className="h-4 w-4 text-primary" />
          <span className="text-sm font-medium text-primary">Trusted Security Partner</span>
        </div>
        
        <h1 className="max-w-4xl font-display text-4xl font-bold leading-tight tracking-tight opacity-0 animate-fade-up md:text-6xl lg:text-7xl" style={{ animationDelay: '0.2s' }}>
          Protect Your Business with{" "}
          <span className="text-gradient">Expert Security</span>{" "}
          Consulting
        </h1>
        
        <p className="mt-6 max-w-2xl text-lg text-muted-foreground opacity-0 animate-fade-up md:text-xl" style={{ animationDelay: '0.3s' }}>
          Information Security, Data Privacy, and Assurance services designed to safeguard your organization against evolving threats.
        </p>
        
        <div className="mt-10 flex flex-col gap-4 opacity-0 animate-fade-up sm:flex-row" style={{ animationDelay: '0.4s' }}>
          <Button size="lg" className="gap-2 font-semibold shadow-glow">
            Schedule Consultation
            <ArrowRight className="h-4 w-4" />
          </Button>
          <Button size="lg" variant="outline" className="font-semibold">
            Learn More
          </Button>
        </div>

        {/* Trust indicators */}
        <div className="mt-20 flex flex-wrap items-center justify-center gap-8 opacity-0 animate-fade-up" style={{ animationDelay: '0.5s' }}>
          <div className="text-center">
            <div className="font-display text-3xl font-bold text-primary">150+</div>
            <div className="text-sm text-muted-foreground">Clients Secured</div>
          </div>
          <div className="h-8 w-px bg-border" />
          <div className="text-center">
            <div className="font-display text-3xl font-bold text-primary">99.9%</div>
            <div className="text-sm text-muted-foreground">Compliance Rate</div>
          </div>
          <div className="h-8 w-px bg-border" />
          <div className="text-center">
            <div className="font-display text-3xl font-bold text-primary">24/7</div>
            <div className="text-sm text-muted-foreground">Expert Support</div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default Hero;
