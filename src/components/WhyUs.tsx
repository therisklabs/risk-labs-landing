import { CheckCircle2 } from "lucide-react";

const benefits = [
  "Industry-certified security professionals (CISSP, CISM, CISA, ISO 27001 LA)",
  "Tailored solutions aligned with regional and international regulations",
  "Proven track record with enterprises across MENA, Europe, and Asia",
  "Transparent pricing with no hidden fees",
  "Ongoing support with coverage across multiple time zones",
  "Rapid response times and dedicated account managers",
];

const WhyUs = () => {
  return (
    <section id="why-us" className="relative py-24">
      <div className="container mx-auto px-6">
        <div className="grid items-center gap-12 lg:grid-cols-2">
          <div>
            <h2 className="font-display text-3xl font-bold tracking-tight md:text-4xl">
              Why Choose{" "}
              <span className="text-gradient">The Risk Labs</span>?
            </h2>
            <p className="mt-4 text-lg text-muted-foreground">
              We combine deep technical expertise with business acumen to deliver security solutions that protect your assets without hindering growth.
            </p>

            <div className="mt-8 space-y-4">
              {benefits.map((benefit) => (
                <div key={benefit} className="flex items-start gap-3">
                  <CheckCircle2 className="mt-0.5 h-5 w-5 flex-shrink-0 text-primary" />
                  <span className="text-muted-foreground">{benefit}</span>
                </div>
              ))}
            </div>
          </div>

          <div className="relative">
            <div className="absolute -inset-4 rounded-2xl bg-glow opacity-40" />
            <div className="relative rounded-2xl border border-border bg-card p-8 shadow-card">
              <div className="grid grid-cols-2 gap-6">
                <div className="text-center">
                  <div className="font-display text-4xl font-bold text-primary">10+</div>
                  <div className="mt-1 text-sm text-muted-foreground">Years Experience</div>
                </div>
                <div className="text-center">
                  <div className="font-display text-4xl font-bold text-primary">500+</div>
                  <div className="mt-1 text-sm text-muted-foreground">Projects Delivered</div>
                </div>
                <div className="text-center">
                  <div className="font-display text-4xl font-bold text-primary">40+</div>
                  <div className="mt-1 text-sm text-muted-foreground">Countries Served</div>
                </div>
                <div className="text-center">
                  <div className="font-display text-4xl font-bold text-primary">15+</div>
                  <div className="mt-1 text-sm text-muted-foreground">Industries Served</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default WhyUs;
