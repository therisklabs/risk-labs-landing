import { Button } from "@/components/ui/button";
import { ArrowRight, Mail, Phone, MapPin } from "lucide-react";

const Contact = () => {
  return (
    <section id="contact" className="relative py-24">
      <div className="container mx-auto px-6">
        <div className="relative overflow-hidden rounded-2xl border border-border bg-card">
          <div className="absolute inset-0 bg-glow opacity-30" />
          
          <div className="relative grid gap-8 p-8 md:grid-cols-2 md:p-12">
            <div>
              <h2 className="font-display text-3xl font-bold tracking-tight md:text-4xl">
                Ready to Secure Your Business?
              </h2>
              <p className="mt-4 text-muted-foreground">
                Let's discuss how we can help protect your organization. Get in touch for a free initial consultation.
              </p>
              
              <div className="mt-8 space-y-4">
                <div className="flex items-center gap-3">
                  <div className="rounded-lg bg-primary/10 p-2">
                    <Mail className="h-5 w-5 text-primary" />
                  </div>
                  <span className="text-muted-foreground">info@therisklabs.com</span>
                </div>
                <div className="flex items-center gap-3">
                  <div className="rounded-lg bg-primary/10 p-2">
                    <Phone className="h-5 w-5 text-primary" />
                  </div>
                  <span className="text-muted-foreground">+971 4 123 4567</span>
                </div>
                <div className="flex items-center gap-3">
                  <div className="rounded-lg bg-primary/10 p-2">
                    <MapPin className="h-5 w-5 text-primary" />
                  </div>
                  <span className="text-muted-foreground">Dubai, United Arab Emirates</span>
                </div>
              </div>
            </div>

            <div className="flex flex-col justify-center">
              <Button size="lg" className="gap-2 font-semibold shadow-glow">
                Schedule Free Consultation
                <ArrowRight className="h-4 w-4" />
              </Button>
              <p className="mt-4 text-center text-sm text-muted-foreground">
                No commitment required. We'll respond within 24 hours.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default Contact;
