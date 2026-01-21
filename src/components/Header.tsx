import { Button } from "@/components/ui/button";
import { Shield } from "lucide-react";

const Header = () => {
  return (
    <header className="fixed top-0 left-0 right-0 z-50 border-b border-border/50 bg-background/80 backdrop-blur-lg">
      <div className="container mx-auto flex h-16 items-center justify-between px-6">
        <div className="flex items-center gap-2">
          <Shield className="h-8 w-8 text-primary" />
          <span className="font-display text-xl font-bold tracking-tight">
            The Risk Labs
          </span>
        </div>
        
        <nav className="hidden items-center gap-8 md:flex">
          <a href="#services" className="text-sm font-medium text-muted-foreground transition-colors hover:text-foreground">
            Services
          </a>
          <a href="#why-us" className="text-sm font-medium text-muted-foreground transition-colors hover:text-foreground">
            Why Us
          </a>
          <a href="#contact" className="text-sm font-medium text-muted-foreground transition-colors hover:text-foreground">
            Contact
          </a>
        </nav>

        <Button size="sm" className="font-medium">
          Get Started
        </Button>
      </div>
    </header>
  );
};

export default Header;
