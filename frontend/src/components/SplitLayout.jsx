import styles from './SplitLayout.module.css';

const DEFAULT_QUOTE =
  '"Digitalizamos los procesos de Protocolo, TT1 y TT2 en un único expediente auditable, con asignación semántica de sinodales y calendarización sin solapamientos."';

export default function SplitLayout({
  quote = DEFAULT_QUOTE,
  quoteSize = '1.6rem',
  quoteWidth = '500px',
  quoteLineHeight = '1.5',
  gridColor = 'rgba(255, 255, 255, 0.03)',
  gridSize = '50px',
  showGrid = true,
  footerColor = '#718096',
  footerSpacing = '1px',
  rightPadding = '3rem',
  rightOverflow = 'visible',
  children,
  overlay,
}) {
  const cssVars = {
    '--quote-size': quoteSize,
    '--quote-width': quoteWidth,
    '--quote-line-height': quoteLineHeight,
    '--grid-color': gridColor,
    '--grid-size': gridSize,
    '--footer-color': footerColor,
    '--footer-spacing': footerSpacing,
    '--right-padding': rightPadding,
    '--right-overflow': rightOverflow,
  };

  return (
    <div className={styles.page} style={cssVars}>
      <div className={`${styles.leftPanel} ${showGrid ? styles.grid : ''}`}>
        <div className={styles.brandContainer}>
          <div className={styles.brandText}>
            <h2>PlataformaTT</h2>
            <p>ESCOM - INSTITUTO POLIT&Eacute;CNICO NACIONAL</p>
          </div>
        </div>

        <div className={styles.quoteContainer}>
          <p className={styles.quoteText}>{quote}</p>
        </div>

        <div className={styles.footerLeft}>TT 2026-B077 &bull; V0.1 PROTOTIPO</div>
      </div>

      <div className={styles.rightPanel}>{children}</div>

      {overlay}
    </div>
  );
}
