import { Shield, Lock, ClipboardCheck, Database, FileSearch, Users } from "lucide-react";

const services = [
  {
    icon: Shield,
    title: "Information Security",
    description: "Comprehensive security assessments, vulnerability management, and security architecture design to protect your critical assets.",
  },
  {
    icon: Lock,
    title: "Data Privacy",
    description: "GDPR, CCPA, and global privacy compliance solutions. We help you build privacy-first practices across your organization.",
  },
  {
    icon: ClipboardCheck,
    title: "Assurance Services",
    description: "Independent audits and assessments including SOC 2, ISO 27001, and custom compliance frameworks.",
  },
  {
    icon: Database,
    title: "Risk Management",
    description: "Identify, assess, and mitigate risks with our proven risk management frameworks and methodologies.",
  },
  {
    icon: FileSearch,
    title: "Security Audits",
    description: "Thorough security audits to evaluate your current posture and provide actionable remediation roadmaps.",
  },
  {
    icon: Users,
    title: "Security Training",
    description: "Empower your team with security awareness training and specialized technical security education.",
  },
];

const Services = () => {
  return (
    <section id="services" className="relative py-24">
      <div className="container mx-auto px-6">
        <div className="mx-auto max-w-2xl text-center">
          <h2 className="font-display text-3xl font-bold tracking-tight md:text-4xl">
            Our <span className="text-gradient">Services</span>
          </h2>
          <p className="mt-4 text-muted-foreground">
            End-to-end security and privacy solutions tailored to your business needs
          </p>
        </div>

        <div className="mt-16 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
          {services.map((service, index) => (
            <div
              key={service.title}
              className="group relative rounded-xl border border-border bg-card p-6 shadow-card transition-all duration-300 hover:border-primary/50 hover:shadow-glow"
              style={{ animationDelay: `${index * 0.1}s` }}
            >
              <div className="mb-4 inline-flex rounded-lg bg-primary/10 p-3">
                <service.icon className="h-6 w-6 text-primary" />
              </div>
              <h3 className="font-display text-xl font-semibold">{service.title}</h3>
              <p className="mt-2 text-sm text-muted-foreground leading-relaxed">
                {service.description}
              </p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default Services;
