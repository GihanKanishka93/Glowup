<!-- Loading spinner -->
<style>
    /* Loading Css start */

    /* Loading container */
    #loading-container {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    /* Loading spinner container */
    #loading-spinner {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: rgba(223, 220, 220, 0.7);
      padding: 100px;
      border-radius: 10px;
      box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.4);
      z-index: 9999;
      backdrop-filter: blur(5px);
      font-size: 20px;
      font-weight: 700;
    }

    /* Loading spinner icon */
    #loading-spinner i {
      font-size: 60px;
      animation: spin 1s infinite linear;
      color: #0e282c;
    }

    /* Keyframe animation for the spinner rotation */
    @keyframes spin {
      from {
          transform: rotate(0deg);
      }
      to {
          transform: rotate(360deg);
      }
    }

    /* Loading Css end */
    </style>
    <div id="loading-container">
        <div id="loading-spinner">
            <i class="fa fa-spinner fa-spin"></i>
        </div>
    </div>
