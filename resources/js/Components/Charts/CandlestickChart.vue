<template>
  <div ref="chart" class="candlestick-chart"></div>
</template>

<script>
import { createChart } from 'lightweight-charts';

export default {
  name: 'CandlestickChart',
  props: {
    data: {
      type: Array,
      required: true
    },
    title: {
      type: String,
      default: ''
    },
    height: {
      type: Number,
      default: 400
    },
    autosize: {
      type: Boolean,
      default: true
    }
  },
  data() {
    return {
      chart: null,
      candlestickSeries: null
    }
  },
  mounted() {
    this.initChart();
  },
  methods: {
    initChart() {
      const chartOptions = {
        width: this.$refs.chart.clientWidth,
        height: this.height,
        layout: {
          backgroundColor: '#ffffff',
          textColor: '#333',
          fontSize: 12,
        },
        grid: {
          vertLines: {
            color: 'rgba(197, 203, 206, 0.5)',
          },
          horzLines: {
            color: 'rgba(197, 203, 206, 0.5)',
          },
        },
        crosshair: {
          mode: 1,
        },
        priceScale: {
          borderColor: 'rgba(197, 203, 206, 0.8)',
        },
        timeScale: {
          borderColor: 'rgba(197, 203, 206, 0.8)',
          timeVisible: true,
          secondsVisible: false,
        },
      };

      this.chart = createChart(this.$refs.chart, chartOptions);
      
      // Handle resizing
      if (this.autosize) {
        const resizeObserver = new ResizeObserver(entries => {
          if (entries.length === 0 || entries[0].target !== this.$refs.chart) {
            return;
          }
          const newRect = entries[0].contentRect;
          this.chart.applyOptions({ width: newRect.width, height: this.height });
        });
        
        resizeObserver.observe(this.$refs.chart);
        
        // Clean up on component destroy
        this.$once('hook:beforeDestroy', () => {
          resizeObserver.disconnect();
        });
      }
      
      // Add candlestick series
      this.candlestickSeries = this.chart.addCandlestickSeries({
        upColor: '#26a69a',
        downColor: '#ef5350',
        borderVisible: false,
        wickUpColor: '#26a69a',
        wickDownColor: '#ef5350',
      });
      
      // Add volume series as histogram
      const volumeSeries = this.chart.addHistogramSeries({
        color: '#26a69a',
        priceFormat: {
          type: 'volume',
        },
        priceScaleId: '',
        scaleMargins: {
          top: 0.8,
          bottom: 0,
        },
      });
      
      // Add title if provided
      if (this.title) {
        this.chart.applyOptions({
          leftPriceScale: {
            visible: true,
            borderColor: 'rgba(197, 203, 206, 0.8)',
          },
          rightPriceScale: {
            visible: true,
            borderColor: 'rgba(197, 203, 206, 0.8)',
          },
          layout: {
            backgroundColor: '#ffffff',
            textColor: '#333',
            fontSize: 12,
          },
          grid: {
            vertLines: {
              color: 'rgba(197, 203, 206, 0.5)',
            },
            horzLines: {
              color: 'rgba(197, 203, 206, 0.5)',
            },
          },
        });
      }
      
      // Process data for candlestick and volume series
      const candlestickData = [];
      const volumeData = [];
      
      for (const item of this.data) {
        const time = typeof item.timestamp === 'number' ? item.timestamp / 1000 : item.timestamp;
        
        // Candlestick data
        candlestickData.push({
          time,
          open: item.open,
          high: item.high,
          low: item.low,
          close: item.close
        });
        
        // Volume data
        if (item.volume !== undefined) {
          volumeData.push({
            time,
            value: item.volume,
            color: item.close >= item.open ? '#26a69a' : '#ef5350'
          });
        }
      }
      
      // Set data
      this.candlestickSeries.setData(candlestickData);
      
      if (volumeData.length > 0) {
        volumeSeries.setData(volumeData);
      }
      
      // Fit content
      this.chart.timeScale().fitContent();
    },
    updateChart(newData) {
      if (!this.chart || !this.candlestickSeries) return;
      
      const candlestickData = [];
      
      for (const item of newData) {
        const time = typeof item.timestamp === 'number' ? item.timestamp / 1000 : item.timestamp;
        
        candlestickData.push({
          time,
          open: item.open,
          high: item.high,
          low: item.low,
          close: item.close
        });
      }
      
      this.candlestickSeries.setData(candlestickData);
      this.chart.timeScale().fitContent();
    }
  },
  watch: {
    data: {
      handler(newData) {
        if (this.chart && this.candlestickSeries) {
          this.updateChart(newData);
        }
      },
      deep: true
    }
  },
  beforeDestroy() {
    if (this.chart) {
      this.chart.remove();
      this.chart = null;
    }
  }
}
</script>

<style scoped>
.candlestick-chart {
  width: 100%;
}
</style>