"use client";

import Image from "next/image";
import { useEffect, useState } from "react";

const NAV_LINKS = [
  { href: "#home", label: "Home" },
  { href: "#workspaces", label: "Workspaces" },
  { href: "#services", label: "Services" },
  { href: "#amenities", label: "Amenities" },
  { href: "#about", label: "About" },
  { href: "#contact", label: "Contact" },
] as const;

export default function Header() {
  const [open, setOpen] = useState(false);

  useEffect(() => {
    document.body.style.overflow = open ? "hidden" : "";
    return () => {
      document.body.style.overflow = "";
    };
  }, [open]);

  useEffect(() => {
    function onKeyDown(event: KeyboardEvent) {
      if (event.key === "Escape") setOpen(false);
    }
    window.addEventListener("keydown", onKeyDown);
    return () => window.removeEventListener("keydown", onKeyDown);
  }, []);

  return (
    <>
      <header className="sticky top-0 z-50 border-b border-white/5 bg-navy/95 backdrop-blur-md">
        <div className="relative mx-auto flex h-[4.5rem] max-w-[1440px] items-center px-5 md:h-20 md:px-8 lg:px-10">
          <a
            href="#home"
            className="absolute left-1/2 z-10 flex -translate-x-1/2 shrink-0 items-center lg:static lg:translate-x-0"
            aria-label="Gold Mark Work Life home"
            onClick={() => setOpen(false)}
          >
            <Image
              src="/images/logo.svg"
              alt="Gold Mark Work Life Business Center LLC"
              width={260}
              height={60}
              priority
              className="h-11 w-auto md:h-12"
            />
          </a>

          <nav
            className="absolute left-1/2 top-1/2 hidden -translate-x-1/2 -translate-y-1/2 items-center gap-7 lg:flex xl:gap-9"
            aria-label="Primary"
          >
            {NAV_LINKS.map((link) => (
              <a
                key={link.href}
                href={link.href}
                className="font-sans text-[0.8125rem] font-medium tracking-[0.08em] text-off-white/90 transition-colors duration-300 hover:text-gold"
              >
                {link.label}
              </a>
            ))}
          </nav>

          <div className="absolute right-5 top-1/2 hidden -translate-y-1/2 items-center md:right-8 lg:flex lg:right-10">
            <a
              href="#contact"
              className="inline-flex items-center justify-center rounded-md bg-gold px-5 py-2.5 font-sans text-[0.8125rem] font-semibold tracking-[0.06em] text-navy transition duration-300 hover:bg-[#e0c04a]"
            >
              Book a Tour
            </a>
          </div>

          <button
            type="button"
            className="absolute right-5 top-1/2 z-[60] inline-flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-md border border-gold/50 text-gold transition hover:bg-gold/10 md:right-8 lg:hidden"
            aria-expanded={open}
            aria-controls="mobile-menu"
            aria-label={open ? "Close menu" : "Open menu"}
            onClick={() => setOpen((value) => !value)}
          >
            <span className="sr-only">Menu</span>
            <span className="flex w-5 flex-col gap-1.5" aria-hidden>
              <span
                className={`block h-0.5 w-full bg-gold transition duration-300 ${open ? "translate-y-2 rotate-45" : ""}`}
              />
              <span
                className={`block h-0.5 w-full bg-gold transition duration-300 ${open ? "opacity-0" : ""}`}
              />
              <span
                className={`block h-0.5 w-full bg-gold transition duration-300 ${open ? "-translate-y-2 -rotate-45" : ""}`}
              />
            </span>
          </button>
        </div>
      </header>

      <div
        id="mobile-menu"
        className={`fixed inset-0 z-[55] bg-navy/98 backdrop-blur-md transition duration-300 lg:hidden ${
          open
            ? "pointer-events-auto opacity-100"
            : "pointer-events-none opacity-0"
        }`}
        aria-hidden={!open}
      >
        <div className="flex h-full flex-col px-6 pb-10 pt-24">
          <nav className="flex flex-1 flex-col gap-1" aria-label="Mobile">
            {NAV_LINKS.map((link) => (
              <a
                key={link.href}
                href={link.href}
                tabIndex={open ? 0 : -1}
                className="border-b border-white/10 py-4 font-sans text-lg font-medium tracking-[0.08em] text-off-white transition hover:text-gold"
                onClick={() => setOpen(false)}
              >
                {link.label}
              </a>
            ))}
          </nav>
          <a
            href="#contact"
            tabIndex={open ? 0 : -1}
            className="mt-6 inline-flex items-center justify-center rounded-md bg-gold px-5 py-3.5 font-sans text-sm font-semibold tracking-[0.06em] text-navy"
            onClick={() => setOpen(false)}
          >
            Book a Tour
          </a>
        </div>
      </div>
    </>
  );
}
