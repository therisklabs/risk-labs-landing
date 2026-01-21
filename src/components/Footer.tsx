import { Shield } from "lucide-react";

const Footer = () => {
  return (
    <footer className="border-t border-border py-12">
      <div className="container mx-auto px-6">
        <div className="flex flex-col items-center justify-between gap-6 md:flex-row">
          <div className="flex items-center gap-2">
            <Shield className="h-6 w-6 text-primary" />
            <span className="font-display text-lg font-bold">The Risk Labs</span>
          </div>
          
          <nav className="flex flex-wrap items-center justify-center gap-6">
            <a href="#services" className="text-sm text-muted-foreground transition-colors hover:text-foreground">
              Services
            </a>
            <a href="#why-us" className="text-sm text-muted-foreground transition-colors hover:text-foreground">
              Why Us
            </a>
            <a href="#contact" className="text-sm text-muted-foreground transition-colors hover:text-foreground">
              Contact
            </a>
            <a href="#" className="text-sm text-muted-foreground transition-colors hover:text-foreground">
              Privacy Policy
            </a>
          </nav>
        </div>
        
        <div className="mt-8 text-center text-sm text-muted-foreground">
          © {new Date().getFullYear()} The Risk Labs. All rights reserved.
        </div>
      </div>
    </footer>
  );
};

export default Footer;
